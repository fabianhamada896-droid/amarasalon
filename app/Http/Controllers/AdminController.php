<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Pembayaran;

class AdminController extends Controller
{
    // Dashboard Admin
    public function dashboard()
    {
        $totalBookingBaru = Booking::where('status_booking', 'Menunggu')->count();
        $totalMenunggu = Booking::where('status_booking', 'Menunggu')->count();
        $totalDikonfirmasi = Booking::where('status_booking', 'Dikonfirmasi')->count();
        $totalDitolak = Booking::where('status_booking', 'Ditolak')->count();
        
        $bookings = Booking::with('user')->latest()->get();

        return view('admin.dashboard', compact(
            'totalBookingBaru', 'totalMenunggu', 'totalDikonfirmasi', 'totalDitolak', 'bookings'
        ));
    }

    // Aksi Admin: Konfirmasi atau Tolak Pembayaran
    public function verifikasiPembayaran(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status_booking = $request->status; // 'Dikonfirmasi' atau 'Ditolak'
        $booking->save();

        return redirect()->back()->with('success', 'Status booking berhasil diperbarui!');
    }
}