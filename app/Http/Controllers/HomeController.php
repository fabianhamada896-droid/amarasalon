<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Dekorasi;
use App\Models\Galeri;
use App\Models\Testimoni;

class HomeController extends Controller
{
    // Halaman Beranda (Halaman 1)
    public function index()
    {
        $layananUnggulan = Layanan::limit(4)->get();
        $galeri = Galeri::limit(6)->get();
        $testimoni = Testimoni::where('status', 'Active')->get();
        
        return view('home', compact('layananUnggulan', 'galeri', 'testimoni'));
    }

    // Halaman Daftar Layanan (Halaman 2)
   public function layanan()
   {
    $layanans = Layanan::all(); // Pastikan variabelnya $layanans
    return view('layanan', compact('layanans'));
   }

    // Halaman Detail Layanan (Halaman 3)
    public function detailLayanan($id)
    {
        $layanan = Layanan::findOrFail($id);
        return view('detail-layanan', compact('layanan'));
    }

    // Halaman Daftar Dekorasi (Halaman 4)
    public function dekorasi()
    {
        $dekorasis = Dekorasi::all();
        return view('dekorasi', compact('dekorasis'));
    }
}