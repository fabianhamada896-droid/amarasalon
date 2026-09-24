<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingDekorasi extends Model
{
    protected $table = 'booking_dekorasis';
    protected $primaryKey = 'id_booking_dekorasi';
    protected $fillable = ['id_booking', 'id_dekorasi', 'harga'];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking', 'id_booking');
    }

    public function dekorasi()
    {
        return $this->belongsTo(Dekorasi::class, 'id_dekorasi', 'id_dekorasi');
    }
}