<?php

namespace App\Http\Controllers\v1;

use App\Models\Reservation;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationCollection;
use App\Http\Resources\ReservationResource;
use App\Http\Responses\ApiResponse;
use App\Repositories\Interfaces\ReservationRepositoryInterface;
use App\Repositories\ReservationRepository;
use Illuminate\Support\Facades\Log;
use Throwable;

class ReservationController extends Controller {

    protected ReservationRepositoryInterface $reservationRepository;

    public function __construct(ReservationRepositoryInterface $reservationRepository) {
        $this->reservationRepository = $reservationRepository;
    }
    
    public function index() {
        try {
            return ApiResponse::success( $this->reservationRepository->getAll() );
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to retrieve reservations');
        }
    }

    public function store(StoreReservationRequest $request) {
        try {

            $newReservation = $this->reservationRepository->store( $request->validated() );
            if (isset($newReservation['error'])) return ApiResponse::error(null, $newReservation['error'], 400);
            return ApiResponse::success($newReservation, 'Reservation created successfully');

        } catch (Throwable $e) {
            Log::error('Error creating reservation: ' . $e->getMessage());
            return ApiResponse::exception($e, 'Failed to create reservation'); 
        }
    }

    public function show(Reservation $reservation) {
        try {
            return ApiResponse::success( $this->reservationRepository->getById($reservation) );
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to retrieve reservation');
        }
    }

    public function update(UpdateReservationRequest $request, Reservation $reservation) {
        try {

            $updateReservation = $this->reservationRepository->update( $request->validated(), $reservation );
            if (isset($updateReservation['error'])) return ApiResponse::error(null, $updateReservation['error'], 400);
            return ApiResponse::success($updateReservation, 'Reservation updated successfully');
            
        } catch (Throwable $e) {
            Log::error('Error updating reservation: ' . $e->getMessage());
            return ApiResponse::exception($e, 'Failed to update reservation'); 
        }
    }

    public function destroy(Reservation $reservation) {
        try {

            $this->reservationRepository->destroy($reservation);
            return ApiResponse::success(null, 'Reservation deleted successfully');
            
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to delete table');
        }
    }

    public function cancelled(Reservation $reservation) {
        try {

            $cancelledReservation = $this->reservationRepository->canceledReservation($reservation);
            if (isset($cancelledReservation['error'])) return ApiResponse::error(null, $cancelledReservation['error'], 400);
            return ApiResponse::success(null, 'Reservation cancelled successfully');

        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to cancel reservation');
        }
    }

}
