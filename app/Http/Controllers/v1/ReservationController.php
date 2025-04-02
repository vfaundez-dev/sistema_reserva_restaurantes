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

    public function show(Reservation $reservation) {
        return new ReservationResource($reservation);
    }

    public function update(UpdateReservationRequest $request, Reservation $reservation) {
        $reservation->update( $request->validated() );
        return new ReservationResource( $reservation->fresh() );
    }

    public function destroy(Reservation $reservation) {
        $reservation->delete();
        return response()->json(['message' => 'Reservation deleted'], 200);
    }

}
