<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $primaryKey = 'id_booking';
    protected $fillable = [
        'kode_booking', 'id_user', 'tanggal_booking', 'jam_booking',
        'total_harga', 'jumlah_dp', 'sisa_pembayaran', 'status_booking', 'catatan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function detailBookings()
    {
        return $this->hasMany(DetailBooking::class, 'id_booking', 'id_booking');
    }

    public function bookingDekorasis()
    {
        return $this->hasMany(BookingDekorasi::class, 'id_booking', 'id_booking');
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'id_booking', 'id_booking');
    }
}