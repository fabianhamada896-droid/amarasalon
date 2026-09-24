<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanans';
    protected $primaryKey = 'id_layanan';
    protected $fillable = ['nama_layanan', 'kategori', 'harga', 'durasi', 'deskripsi'];

    public function detailBookings()
    {
        return $this->hasMany(DetailBooking::class, 'id_layanan', 'id_layanan');
    }
}