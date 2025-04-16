<?php

namespace App\Repositories;

use App\Http\Resources\ReservationCollection;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Models\Table;
use App\Repositories\Interfaces\ReservationRepositoryInterface;
use App\Repositories\Interfaces\TableRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class ReservationRepository implements ReservationRepositoryInterface {

    protected TableRepositoryInterface $tableRepository;
    protected $initHour = '11:00';
    protected $endHour = '22:00';

    public function __construct(TableRepositoryInterface $tableRepository) {
        $this->tableRepository = $tableRepository;
    }
    
    public function getAll(): ReservationCollection {
        return new ReservationCollection( Reservation::orderBy('id', 'desc')->get() );
    }

    public function getById(Reservation $reservation): ReservationResource {
        return ReservationResource::make($reservation);
    }

    public function store(array $data): ReservationResource {
        DB::beginTransaction();
        try {

            // Validations
            if ( $validateTables = $this->validateTables($data['table_ids']) ) return $validateTables;
            if ( $validateReservations = $this->validateReservation($data) ) return $validateReservations;

            $newReservation = Reservation::create($data);
            $newReservation->tables()->attach($data['table_ids']);
            Table::whereIn('id', $data['table_ids'])->update(['is_available' => false]);
            DB::commit();
            return ReservationResource::make( $newReservation->fresh() );
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(array $data, Reservation $reservation): ReservationResource {
        DB::beginTransaction();
        try {

            // Validations
            if ($reservation->status == 'completed')
                throw new \Exception('Completed reservations cannot be updated');
            if ( $validateTables = $this->validateTables($data['table_ids']) ) return $validateTables;
            if ( $validateReservations = $this->validateReservation($data) ) return $validateReservations;

            // If change status to completed
            if (isset($data['status']) && $data['status'] == 'completed')
                return $this->completed($reservation);

            // If change status to canceled 
            if (isset($data['status']) && $data['status'] == 'canceled')
                return $this->canceled($reservation);

            // Old Tables
            $oldTableIds = $reservation->tables()->pluck('id')->toArray();
            // Update Reservation
            $reservation->update($data);
            // New Tables
            $reservation->tables()->sync($data['table_ids']);
            // Release old tables
            Table::whereIn( 'id', array_diff($oldTableIds, $data['table_ids']))->update(['is_available' => true]);
            // Occupied new tables
            Table::whereIn( 'id', array_diff($data['table_ids'], $oldTableIds) )->update(['is_available' => false]);
            // Completed and response
            DB::commit();
            return ReservationResource::make( $reservation->fresh() );
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function destroy(Reservation $reservation): bool {
        DB::beginTransaction();
        try {
            
            // Release tables
            $reservation->tables()->update(['is_available' => true]);
            // Delete Relations
            $reservation->tables()->detach();
            // Delete Reservation
            $deleted = $reservation->delete();
            DB::commit();
            return $deleted;
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    public function count(): int {
        return Reservation::count();
    }

    public function exist(Reservation $reservation): bool {
        return Reservation::where('id', $reservation->id)->exists();
    }

    public function completed(Reservation $reservation): ReservationResource {
        return $this->changeStatus($reservation, 'completed');
    }

    public function canceled(Reservation $reservation): ReservationResource {
        return $this->changeStatus($reservation, 'canceled');
    }

    /* Status */

    private function changeStatus(Reservation $reservation, string $status): ReservationResource {
        DB::beginTransaction();
        try {

            if ($reservation->status == $status)
                throw new \Exception("Reservation already {$status}");
            if ($reservation->status == 'completed')
                throw new \Exception('Completed reservations cannot be modified');

            $reservation->update(['status' => $status]);
            $reservation->tables()->update(['is_available' => true]);

            DB::commit();
            return ReservationResource::make($reservation->fresh());
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /* Validations */

    private function validateTables(array $tableIds) {
        $tables = Table::findMany($tableIds);

        if ($tables->count() !== count($tableIds))
            throw new \Exception('One or more tables do not exist');

        foreach ($tables as $table) {
            if (!$this->tableRepository->isAvailable($table)) {
                throw new \Exception("Table {$table->id} is not available");
            }
        }

        return null;
    }

    private function validateReservation(array $data, ?Reservation $reservation = null) {

        // Total Capacity
        $totalCapacity = Table::whereIn('id', $data['table_ids'])->sum('capacity');
        if ($totalCapacity < $data['number_of_peoples'])
            throw new \Exception('Total capacity of selected tables is less than number of peoples');

        // Reservation Hours
        $hour = \Carbon\Carbon::parse($data['reservation_time'])->format('H:i');
        if ( $hour < $this->initHour || $hour > $this->endHour ) {
            throw new \Exception('Reservation hours: 11:00 AM to 22:00 PM');
        }

        // Reservations two hours in advance
        $reservationDateTime = \Carbon\Carbon::parse($data['reservation_date'].' '.$data['reservation_time']);
        $now = \Carbon\Carbon::now();

        if ( $reservationDateTime->isPast() )
            throw new \Exception('Reservation date and time must be in the future');

        if ( $now->diffInHours($reservationDateTime, false) < 2)
            throw new \Exception('Reservations require at least 2 hours notice');

        // Check for reservations on the same date and time for the selected tables
        $queryReservation = Reservation::whereIn('status', ['pending', 'confirmed'])
            ->where('reservation_date', $data['reservation_date'])
            ->where('reservation_time', $data['reservation_time'])
            ->whereHas('tables', function($query) use ($data) {
                $query->whereIn('tables.id', $data['table_ids']);
            });
        
        if ($reservation) {
            $queryReservation->where('id', '!=', $reservation->id);
        }

        if ($queryReservation->exists())
            throw new \Exception('One or more tables are already reserved for that date and time');

        return null;
    }

}
