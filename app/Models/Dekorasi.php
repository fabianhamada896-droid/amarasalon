<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dekorasi extends Model
{
    protected $table = 'dekorasis';
    protected $primaryKey = 'id_dekorasi';
    protected $fillable = ['nama_paket', 'jenis_dekorasi', 'harga', 'deskripsi'];

    public function bookingDekorasis()
    {
        return $this->hasMany(BookingDekorasi::class, 'id_dekorasi', 'id_dekorasi');
    }
}