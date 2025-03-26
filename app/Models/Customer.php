<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'registration_date',
    ];

    protected $casts = [
        'registration_date' => 'datetime',
    ];

    public function reservations() {
        return $this->hasMany(Reservation::class);
    }
    
}
