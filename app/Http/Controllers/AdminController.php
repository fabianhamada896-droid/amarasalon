<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\Layanan;
use App\Models\Dekorasi;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    // ==================== DASHBOARD & BOOKING ====================

    // Dashboard Admin
    public function dashboard()
    {
        $totalBookingBaru = Booking::where('status_booking', 'Menunggu')->count();
        $totalMenunggu = Booking::where('status_booking', 'Menunggu')->count();
        $totalDikonfirmasi = Booking::where('status_booking', 'Dikonfirmasi')->count();
        $totalDitolak = Booking::where('status_booking', 'Ditolak')->count();
        
        $bookings = Booking::with('user', 'pembayarans')->latest()->get();

        return view('admin.dashboard', compact(
            'totalBookingBaru', 'totalMenunggu', 'totalDikonfirmasi', 'totalDitolak', 'bookings'
        ));
    }

    // Aksi Admin: Halaman Daftar Pembayaran
    public function pembayaranIndex()
    {
        $pembayarans = Pembayaran::with('booking')->latest()->get();

        return view('admin.pembayaran', compact('pembayarans'));
    }

    // Aksi Admin: Konfirmasi atau Tolak Pembayaran
    public function verifikasiPembayaran(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Valid,Ditolak,Dikonfirmasi',
        ]);

        $pembayaran = Pembayaran::find($id);

        if ($pembayaran) {
            $statusPembayaran = ($request->status == 'Ditolak') ? 'Ditolak' : 'Valid';
            $statusBooking = ($request->status == 'Ditolak') ? 'Ditolak' : 'Dikonfirmasi';

            $pembayaran->update([
                'status_pembayaran' => $statusPembayaran,
                'catatan' => $request->catatan,
            ]);

            if ($pembayaran->booking) {
                $pembayaran->booking->update([
                    'status_booking' => $statusBooking,
                ]);
            }
        } else {
            $booking = Booking::findOrFail($id);
            $booking->status_booking = $request->status;
            $booking->save();

            $pembayaranTerakhir = $booking->pembayarans()->latest()->first();
            if ($pembayaranTerakhir) {
                $pembayaranTerakhir->update([
                    'status_pembayaran' => ($request->status == 'Dikonfirmasi') ? 'Valid' : 'Ditolak'
                ]);
            }
        }

        return redirect()->back()->with('success', 'Status pembayaran dan booking berhasil diperbarui!');
    }


    // ==================== MANAJEMEN KATALOG (LAYANAN & DEKORASI) ====================

    // Tampilkan halaman daftar layanan & dekorasi admin
    public function katalogIndex()
    {
        $layanans = Layanan::all();
        $dekorasis = Dekorasi::all();
        
        return view('admin.katalog.index', compact('layanans', 'dekorasis'));
    }

    public function storeLayanan(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'kategori' => 'required|string',
            'harga' => 'required|numeric',
            'durasi' => 'nullable|integer', // <-- Tambahkan ini
            'deskripsi' => 'nullable|string',
        ]);

        Layanan::create($request->all());

        return redirect()->back()->with('success', 'Layanan berhasil ditambahkan!');
    }
    // Hapus Layanan
    public function destroyLayanan($id)
    {
        $layanan = Layanan::findOrFail($id);
        $layanan->delete();

        return redirect()->back()->with('success', 'Layanan berhasil dihapus!');
    }

   // Tambah Dekorasi Baru
    public function storeDekorasi(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'jenis_dekorasi' => 'required|string',
            'harga' => 'required|numeric',
            'estimasi_pengerjaan' => 'nullable|string', // <-- Tambahkan ini
            'kelengkapan' => 'nullable|string',         // <-- Tambahkan ini
            'deskripsi' => 'nullable|string',
        ]);

        Dekorasi::create($request->all());

        return redirect()->back()->with('success', 'Paket dekorasi berhasil ditambahkan!');
    }
    // Hapus Dekorasi
    public function destroyDekorasi($id)
    {
        $dekorasi = Dekorasi::findOrFail($id);
        $dekorasi->delete();

        return redirect()->back()->with('success', 'Dekorasi berhasil dihapus!');
    }
}