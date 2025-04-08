<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model {
    use HasFactory;

    protected $fillable = [
        'reservation_date',
        'reservation_time',
        'number_of_peoples',
        'special_request',
        'status',
        'notes',
        'customer_id',
        'user_id',
    ];

    protected $casts = [
        'reservation_date' => 'datetime',
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function tables() {
        return $this->belongsToMany(Table::class, 'reservation_table')->withTimestamps();
    }
    
}
