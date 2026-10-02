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
        // Validasi
        $request->validate([
            'id_item' => 'required',
            'tipe' => 'required',
            'tanggal_acara' => 'required|date',
            'catatan' => 'nullable|string',
        ]);


        // ======================================================
        // AMBIL HARGA BERDASARKAN TIPE
        // ======================================================

        if ($request->tipe == 'dekorasi') {

            $item = Dekorasi::findOrFail($request->id_item);

            $harga = $item->harga;

        } else {

            $item = Layanan::findOrFail($request->id_item);

            $harga = $item->harga;
        }


        // ======================================================
        // BUAT BOOKING
        // ======================================================

        $booking = Booking::create([

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


        // ======================================================
        // LANGSUNG KE HALAMAN QRIS
        // ======================================================

        return redirect()
            ->route('booking.qris', $booking->id_booking);
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
        // ======================================================
        // CARI BOOKING
        // ======================================================

        // Hanya booking milik user yang login
        // yang boleh membuka halaman QRIS

        $booking = Booking::where('id_booking', $id)
            ->where('id_user', Auth::id())
            ->firstOrFail();


        // ======================================================
        // AMBIL PEMBAYARAN TERAKHIR
        // ======================================================

        $pembayaran = $booking->pembayarans()
            ->latest()
            ->first();


        // ======================================================
        // TAMPILKAN HALAMAN QRIS
        // ======================================================

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
        // ======================================================
        // VALIDASI FILE
        // ======================================================

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);


        // ======================================================
        // CARI BOOKING
        // ======================================================

        $booking = Booking::where('id_booking', $id)
            ->where('id_user', Auth::id())
            ->firstOrFail();


        // ======================================================
        // CEK FILE
        // ======================================================

        if ($request->hasFile('bukti_pembayaran')) {

            $file = $request->file('bukti_pembayaran');


            // ==================================================
            // BUAT NAMA FILE
            // ==================================================

            $filename =
                time()
                . '_'
                . $booking->kode_booking
                . '.'
                . $file->getClientOriginalExtension();


            // ==================================================
            // SIMPAN FILE
            // ==================================================

            $file->storeAs(
                'bukti_pembayaran',
                $filename,
                'public'
            );


            // ==================================================
            // SIMPAN PEMBAYARAN KE DATABASE
            // ==================================================

            Pembayaran::create([

                'id_booking' => $booking->id_booking,

                'jumlah_bayar' => $booking->total_harga,

                'metode_pembayaran' => 'QRIS',

                'jenis_pembayaran' => 'DP',

                'bukti_pembayaran' => $filename,

                'tanggal_bayar' => now(),

                'status_pembayaran' => 'Pending',
            ]);


            // ==================================================
            // UPDATE STATUS BOOKING
            // ==================================================

            $booking->update([
                'status_booking' => 'Menunggu',
            ]);
        }


        // ======================================================
        // KEMBALI KE RIWAYAT
        // ======================================================

        return redirect()
            ->route('booking.riwayat')
            ->with(
                'success',
                'Bukti pembayaran berhasil diupload! Menunggu verifikasi admin.'
            );
    }
}