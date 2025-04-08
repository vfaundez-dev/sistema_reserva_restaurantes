<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model {
    use HasFactory;

    protected $fillable = [
        'is_available',
        'capacity',
        'location',
    ];

    public function reservations() {
        return $this->belongsToMany(Reservation::class, 'reservation_table')->withTimestamps();
    }
    
}
