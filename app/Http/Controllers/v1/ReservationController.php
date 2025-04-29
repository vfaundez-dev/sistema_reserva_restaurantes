<?php

namespace App\Http\Controllers\v1;

use App\Models\Reservation;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Repositories\Interfaces\ReservationRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class ReservationController extends Controller {

    protected ReservationRepositoryInterface $reservationRepository;

    public function __construct(ReservationRepositoryInterface $reservationRepository) {
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/reservations",
     *     tags={"Reservations"},
     *     summary="Get all reservation",
     *     description="Retrieve a list of all reservations.",
     *     operationId="getAllReservations",
     *     security={{"BearerAuth": {}}},
     *     @OA\Response(response=200, ref="#/components/responses/ReservationSuccess"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function index() {
        try {
            return ApiResponse::success( $this->reservationRepository->getAll(), '', Response::HTTP_OK );
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to retrieve reservations');
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/reservations",
     *     tags={"Reservations"},
     *     summary="Create a new reservation",
     *     description="Store a new reservation in the system.",
     *     operationId="storeReservation",
     *     security={{"BearerAuth": {}}},
     *     @OA\RequestBody(ref="#/components/requestBodies/StoreReservationRequest"),
     *     @OA\Response(response=201, ref="#/components/responses/ReservationSuccess"),
     *     @OA\Response(response=400, ref="#/components/responses/ReservationInvalidRequest"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function store(StoreReservationRequest $request) {
        try {

            $newReservation = $this->reservationRepository->store( $request->validated() );
            if (isset($newReservation['error'])) return ApiResponse::error(null, $newReservation['error'], Response::HTTP_BAD_REQUEST);
            return ApiResponse::success($newReservation, 'Reservation created successfully', Response::HTTP_CREATED);

        } catch (Throwable $e) {
            Log::error('Error creating reservation: ' . $e->getMessage());
            return ApiResponse::exception($e, 'Failed to create reservation'); 
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/reservations/{reservation}",
     *     tags={"Reservations"},
     *     summary="Get a reservation by ID",
     *     description="Retrieve a specific reservation by its ID.",
     *     operationId="getReservationById",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="reservation",
     *         in="path",
     *         required=true,
     *         description="ID of the reservation to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, ref="#/components/responses/ReservationSuccessId"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFoundError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function show(Reservation $reservation) {
        try {
            return ApiResponse::success( $this->reservationRepository->getById($reservation), '', Response::HTTP_OK );
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to retrieve reservation');
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/reservations/{reservation}",
     *     tags={"Reservations"},
     *     summary="Update a reservation",
     *     description="Update an existing reservation in the system.",
     *     operationId="updateReservation",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="reservation",
     *         in="path",
     *         required=true,
     *         description="ID of the reservation to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateReservationRequest"),
     *     @OA\Response(response=200, ref="#/components/responses/ReservationSuccessId"),
     *     @OA\Response(response=400, ref="#/components/responses/ReservationInvalidRequest"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFoundError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function update(UpdateReservationRequest $request, Reservation $reservation) {
        try {

            $updateReservation = $this->reservationRepository->update( $request->validated(), $reservation );
            if (isset($updateReservation['error'])) return ApiResponse::error(null, $updateReservation['error'], 400);
            return ApiResponse::success($updateReservation, 'Reservation updated successfully', Response::HTTP_OK);
            
        } catch (Throwable $e) {
            Log::error('Error updating reservation: ' . $e->getMessage());
            return ApiResponse::exception($e, 'Failed to update reservation'); 
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/reservations/{reservation}",
     *     tags={"Reservations"},
     *     summary="Delete a reservation",
     *     description="Delete a specific reservation by its ID.",
     *     operationId="deleteReservation",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="reservation",
     *         in="path",
     *         required=true,
     *         description="ID of the reservation to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Reservation deleted successfully"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFoundError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function destroy(Reservation $reservation) {
        try {

            $this->reservationRepository->destroy($reservation);
            return ApiResponse::success(null, 'Reservation deleted successfully', Response::HTTP_OK);
            
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to delete reservation');
        }
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/reservations/{reservation}/completed",
     *     tags={"Reservations"},
     *     summary="Complete a reservation",
     *     description="Mark a specific reservation as completed.",
     *     operationId="completeReservation",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="reservation",
     *         in="path",
     *         required=true,
     *         description="ID of the reservation to complete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Reservation completed successfully"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFoundError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function completed(Reservation $reservation) {
        try {

            $completedReservation = $this->reservationRepository->completed($reservation);
            if (isset($completedReservation['error']))
                return ApiResponse::error(null, $completedReservation['error'], Response::HTTP_BAD_REQUEST);
            return ApiResponse::success(null, 'Reservation completed successfully', Response::HTTP_OK);

        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to completed reservation');
        }
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/reservations/{reservation}/cancelled",
     *     tags={"Reservations"},
     *     summary="Cancel a reservation",
     *     description="Mark a specific reservation as cancelled.",
     *     operationId="cancelReservation",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="reservation",
     *         in="path",
     *         required=true,
     *         description="ID of the reservation to cancel",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Reservation cancelled successfully"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFoundError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function cancelled(Reservation $reservation) {
        try {

            $cancelledReservation = $this->reservationRepository->canceled($reservation);
            if (isset($cancelledReservation['error'])) return ApiResponse::error(null, $cancelledReservation['error'], 400);
            return ApiResponse::success(null, 'Reservation cancelled successfully');

        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to canceled reservation');
        }
    }

}
