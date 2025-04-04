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

    public function __construct(TableRepositoryInterface $tableRepository) {
        $this->tableRepository = $tableRepository;
    }
    
    public function getAll(): ReservationCollection {
        return new ReservationCollection( Reservation::all() );
    }

    public function getById(Reservation $reservation): ReservationResource {
        return ReservationResource::make($reservation);
    }

    public function store(array $data): ReservationResource|array {
        DB::beginTransaction();
        try {
            
            // Validations
            $validateTable = $this->validateTable($data['table_id']);
            if ($validateTable) return $validateTable;

            $newReservation = Reservation::create($data);
            $newReservation->table->update(['is_available' => false]);
            DB::commit();
            return ReservationResource::make( $newReservation->fresh() );
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(array $data, Reservation $reservation): ReservationResource|array {
        DB::beginTransaction();
        try {

            // Validations
            if ($reservation->table_id != $data['table_id']) {
                $validateTable = $this->validateTable($data['table_id']);
                if ($validateTable) return $validateTable;
            }
            
            $reservation->update($data);
            $reservation->table->update(['is_available' => false]);
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

    public function canceledReservation(Reservation $reservation): bool|array {
        DB::beginTransaction();
        try {

            // Validations
            if($reservation->status == 'canceled') return ['error' => 'Reservation already canceled'];

            $reservation->update(['status' => 'canceled']);
            $reservation->table->update(['is_available' => true]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function validateTable(int $tableId): ?array {
        $table = Table::find($tableId);

        if ($this->tableRepository->hasActiveReservation($table))
            return ['error' => 'Table already occupied in a reservation'];

        return null;
    }

}
