<?php

namespace App\Http\Controllers\v1;

use App\Models\Reservation;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationCollection;
use App\Http\Resources\ReservationResource;

class ReservationController extends Controller {
    
    public function index() {
        $reservations = Reservation::all();
        return new ReservationCollection($reservations);
    }

    public function store(StoreReservationRequest $request) {
        $newReservation = Reservation::create( $request->validated() );
        return new ReservationResource( $newReservation->fresh() );
    }

    public function show(string $id) {
        $reservation = Reservation::find($id);
        if (!$reservation) return response()->json(['message' => 'Reservation not found'], 404);
        return new ReservationResource($reservation);
    }

    public function update(UpdateReservationRequest $request, string $id) {
        $reservation = Reservation::find($id);
        if (!$reservation) return response()->json(['message' => 'Reservation not found'], 404);
        $reservation->update( $request->validated() );
        return new ReservationResource( $reservation->fresh() );
    }

    public function destroy(string $id) {
        //
    }

}
