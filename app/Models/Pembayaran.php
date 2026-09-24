<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';
    protected $primaryKey = 'id_pembayaran';
    protected $fillable = [
        'id_booking', 'jumlah_bayar', 'metode_pembayaran', 
        'jenis_pembayaran', 'bukti_pembayaran', 'tanggal_bayar', 
        'status_pembayaran', 'id_admin', 'catatan'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking', 'id_booking');
    }
}