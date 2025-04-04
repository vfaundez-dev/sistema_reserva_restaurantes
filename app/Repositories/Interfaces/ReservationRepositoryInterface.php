<?php

namespace App\Repositories\Interfaces;

use App\Http\Resources\ReservationCollection;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;

interface ReservationRepositoryInterface {
    public function getAll(): ReservationCollection;
    public function getById(Reservation $customer): ReservationResource;
    public function store(array $data): ReservationResource|array;
    public function update(array $data, Reservation $reservation): ReservationResource|array;
    public function destroy(Reservation $reservation): bool;
    public function count(): int;
    public function exist(Reservation $reservation): bool;
    public function canceledReservation(Reservation $reservation): bool|array;
}
