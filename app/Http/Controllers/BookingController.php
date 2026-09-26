<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Dekorasi;
use App\Models\Booking;

class BookingController extends Controller
{
    // Menampilkan form booking berdasarkan Layanan atau Dekorasi
    public function create(Request $request, $id)
    {
        // Cek apakah ini booking dekorasi atau layanan berdasarkan parameter tipe atau dari route
        $tipe = $request->query('type', 'layanan');
        
        if ($tipe == 'dekorasi') {
            $item = Dekorasi::findOrFail($id);
            // Ubah properti agar seragam dibaca di view
            $item->nama_item = $item->nama_paket;
            $item->kategori_item = $item->jenis_dekorasi ?? 'Dekorasi';
        } else {
            $item = Layanan::findOrFail($id);
            $item->nama_item = $item->nama_layanan;
            $item->kategori_item = $item->kategori;
        }

        return view('booking', compact('item', 'tipe'));
    }

    // Menyimpan data pemesanan ke database
  public function store(Request $request)
    {
        $request->validate([
            'id_item' => 'required',
            'tipe' => 'required',
            'tanggal_acara' => 'required|date',
            'catatan' => 'nullable|string',
        ]);

        // AMAN: Pastikan user ID 1 otomatis ada di database agar tidak foreign key error
        \App\Models\User::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Maman',
                'email' => 'maman@example.com',
                'password' => bcrypt('password')
            ]
        );

        // Ambil harga berdasarkan tipe
        if ($request->tipe == 'dekorasi') {
            $item = Dekorasi::findOrFail($request->id_item);
            $harga = $item->harga;
        } else {
            $item = Layanan::findOrFail($request->id_item);
            $harga = $item->harga;
        }

        Booking::create([
            'kode_booking' => 'AMR' . rand(100, 999),
            'id_user' => 1,
            'tanggal_booking' => $request->tanggal_acara,
            'jam_booking' => '10:00:00',
            'total_harga' => $harga,
            'jumlah_dp' => 0,
            'sisa_pembayaran' => $harga,
            'status_booking' => 'Menunggu',
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('home')->with('success', 'Booking berhasil dibuat!');
    }

    // Menampilkan riwayat pesanan user
    public function index()
    {
        // Ambil data booking milik user yang sedang login (sementara hardcode id_user = 1)
        // Urutkan dari yang paling baru menggunakan latest() atau orderBy('created_at', 'desc')
        $bookings = Booking::where('id_user', 1)->latest()->get();

        return view('riwayat', compact('bookings'));
    }
}