<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model {
    use HasFactory;

    protected $fillable = [
        'reservation_date',
        'status',
        'notes',
        'customer_id',
        'table_id',
        'user_id',
    ];

    protected $casts = [
        'reservation_date' => 'datetime',
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function table() {
        return $this->belongsTo(Table::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    
}
