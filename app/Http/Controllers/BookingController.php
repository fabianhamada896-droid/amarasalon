<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Dekorasi;
use App\Models\Booking;
use App\Models\Pembayaran;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // ==========================================================
    // FORM BOOKING
    // ==========================================================

    public function create(Request $request, $id)
    {
        // Cek tipe booking
        $tipe = $request->query('type', 'layanan');

        if ($tipe == 'dekorasi') {

            $item = Dekorasi::findOrFail($id);

            // Samakan nama property dengan layanan
            $item->nama_item = $item->nama_paket;
            $item->kategori_item = $item->jenis_dekorasi ?? 'Dekorasi';

        } else {

            $item = Layanan::findOrFail($id);

            $item->nama_item = $item->nama_layanan;
            $item->kategori_item = $item->kategori;
        }

        return view('booking', compact('item', 'tipe'));
    }


    // ==========================================================
    // SIMPAN BOOKING
    // ==========================================================

    public function store(Request $request)
    {
        $request->validate([
            'id_item' => 'required',
            'tipe' => 'required',
            'tanggal_acara' => 'required|date',
            'catatan' => 'nullable|string',
        ]);

        // Ambil harga berdasarkan tipe
        if ($request->tipe == 'dekorasi') {

            $item = Dekorasi::findOrFail($request->id_item);
            $harga = $item->harga;

        } else {

            $item = Layanan::findOrFail($request->id_item);
            $harga = $item->harga;
        }

        // Buat booking
        Booking::create([
            'kode_booking' => 'AMR' . rand(100, 999),
            'id_user' => Auth::id(),
            'tanggal_booking' => $request->tanggal_acara,
            'jam_booking' => '10:00:00',
            'total_harga' => $harga,
            'jumlah_dp' => 0,
            'sisa_pembayaran' => $harga,
            'status_booking' => 'Menunggu',
            'catatan' => $request->catatan,
        ]);

        return redirect()
            ->route('booking.riwayat')
            ->with('success', 'Booking berhasil dibuat!');
    }


    // ==========================================================
    // RIWAYAT PESANAN
    // ==========================================================

    public function index()
    {
        $bookings = Booking::with('pembayarans')
            ->where('id_user', Auth::id())
            ->latest()
            ->get();

        return view('riwayat', compact('bookings'));
    }


    // ==========================================================
    // HALAMAN QRIS
    // ==========================================================

    public function qris($id)
    {
        /*
        |--------------------------------------------------------------------------
        | Cari booking
        |--------------------------------------------------------------------------
        | Hanya booking milik user yang sedang login yang boleh dibuka.
        |--------------------------------------------------------------------------
        */

        $booking = Booking::where('id_booking', $id)
            ->where('id_user', Auth::id())
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Ambil pembayaran
        |--------------------------------------------------------------------------
        */

        $pembayaran = $booking->pembayarans()
            ->latest()
            ->first();

        return view('qris', compact(
            'booking',
            'pembayaran'
        ));
    }


    // ==========================================================
    // UPLOAD BUKTI PEMBAYARAN
    // ==========================================================

    public function uploadPembayaran(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Pastikan booking milik user yang sedang login
        |--------------------------------------------------------------------------
        */

        $booking = Booking::where('id_booking', $id)
            ->where('id_user', Auth::id())
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Upload file
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('bukti_pembayaran')) {

            $file = $request->file('bukti_pembayaran');

            $filename =
                time()
                . '_'
                . $booking->kode_booking
                . '.'
                . $file->getClientOriginalExtension();


            /*
            |--------------------------------------------------------------------------
            | Simpan ke:
            | storage/app/public/bukti_pembayaran/
            |--------------------------------------------------------------------------
            */

            $file->storeAs(
                'bukti_pembayaran',
                $filename,
                'public'
            );


            /*
            |--------------------------------------------------------------------------
            | Simpan pembayaran ke database
            |--------------------------------------------------------------------------
            */

            Pembayaran::create([
                'id_booking' => $booking->id_booking,
                'jumlah_bayar' => $booking->total_harga,
                'metode_pembayaran' => 'QRIS',
                'jenis_pembayaran' => 'DP',
                'bukti_pembayaran' => $filename,
                'tanggal_bayar' => now(),
                'status_pembayaran' => 'Pending',
            ]);


            /*
            |--------------------------------------------------------------------------
            | Update status booking
            |--------------------------------------------------------------------------
            */

            $booking->update([
                'status_booking' => 'Menunggu',
            ]);
        }


        return redirect()
            ->route('booking.riwayat')
            ->with(
                'success',
                'Bukti pembayaran berhasil diupload! Menunggu verifikasi admin.'
            );
    }
}
