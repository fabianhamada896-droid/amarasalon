<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\Layanan;
use App\Models\Dekorasi;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

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

        $bookings = Booking::with('user', 'pembayarans')
            ->latest()
            ->get();

        return view('admin.dashboard', compact(
            'totalBookingBaru',
            'totalMenunggu',
            'totalDikonfirmasi',
            'totalDitolak',
            'bookings'
        ));
    }

    // Aksi Admin: Halaman Daftar Pembayaran
    public function pembayaranIndex()
    {
        $pembayarans = Pembayaran::with('booking')
            ->latest()
            ->get();

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

            $statusPembayaran = ($request->status == 'Ditolak')
                ? 'Ditolak'
                : 'Valid';

            $statusBooking = ($request->status == 'Ditolak')
                ? 'Ditolak'
                : 'Dikonfirmasi';

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

            $pembayaranTerakhir = $booking->pembayarans()
                ->latest()
                ->first();

            if ($pembayaranTerakhir) {
                $pembayaranTerakhir->update([
                    'status_pembayaran' =>
                        ($request->status == 'Dikonfirmasi')
                        ? 'Valid'
                        : 'Ditolak'
                ]);
            }
        }

        return redirect()->back()->with(
            'success',
            'Status pembayaran dan booking berhasil diperbarui!'
        );
    }


    // ==================== MANAJEMEN KATALOG ====================

    // Tampilkan halaman katalog admin
    public function katalogIndex()
    {
        $layanans = Layanan::latest()->get();
        $dekorasis = Dekorasi::latest()->get();

        return view(
            'admin.katalog.index',
            compact('layanans', 'dekorasis')
        );
    }


    // ==================== LAYANAN ====================

    // Tambah Layanan Baru
    public function storeLayanan(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'kategori' => 'required|string|max:50',
            'harga' => 'required|numeric|min:0',
            'durasi' => 'nullable|integer|min:0',
            'deskripsi' => 'nullable|string',

            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $namaFileFoto = null;

        // Upload foto
        if ($request->hasFile('foto')) {

            $file = $request->file('foto');

            // Buat nama file unik
            $fileNameOnly = time()
                . '_'
                . uniqid()
                . '.'
                . $file->getClientOriginalExtension();

            // Simpan ke:
            // storage/app/public/layanan/
            $namaFileFoto = $file->storeAs(
                'layanan',
                $fileNameOnly,
                'public'
            );
        }

        // Simpan ke database
        Layanan::create([
            'nama_layanan' => $request->nama_layanan,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'durasi' => $request->durasi,
            'deskripsi' => $request->deskripsi,
            'foto' => $namaFileFoto,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Layanan berhasil ditambahkan!');
    }


    // Hapus Layanan
    public function destroyLayanan($id)
    {
        $layanan = Layanan::findOrFail($id);

        // Hapus foto dari storage
        if (
            $layanan->foto &&
            Storage::disk('public')->exists($layanan->foto)
        ) {
            Storage::disk('public')->delete($layanan->foto);
        }

        // Hapus data database
        $layanan->delete();

        return redirect()
            ->back()
            ->with('success', 'Layanan berhasil dihapus!');
    }


    // ==================== DEKORASI ====================

    // Tambah Paket Dekorasi
    public function storeDekorasi(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'jenis_dekorasi' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'estimasi_pengerjaan' => 'nullable|string',
            'kelengkapan' => 'nullable|string',
            'deskripsi' => 'nullable|string',

            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $namaFileFoto = null;

        // Upload foto dekorasi
        if ($request->hasFile('foto')) {

            $file = $request->file('foto');

            $fileNameOnly = time()
                . '_'
                . uniqid()
                . '.'
                . $file->getClientOriginalExtension();

            // Simpan ke:
            // storage/app/public/dekorasi/
            $namaFileFoto = $file->storeAs(
                'dekorasi',
                $fileNameOnly,
                'public'
            );
        }

        // Simpan ke database
        Dekorasi::create([
            'nama_paket' => $request->nama_paket,
            'jenis_dekorasi' => $request->jenis_dekorasi,
            'harga' => $request->harga,
            'estimasi_pengerjaan' => $request->estimasi_pengerjaan,
            'kelengkapan' => $request->kelengkapan,
            'deskripsi' => $request->deskripsi,
            'foto' => $namaFileFoto,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Paket dekorasi berhasil ditambahkan!');
    }


    // Hapus Dekorasi
    public function destroyDekorasi($id)
    {
        $dekorasi = Dekorasi::findOrFail($id);

        // Hapus foto dari storage
        if (
            $dekorasi->foto &&
            Storage::disk('public')->exists($dekorasi->foto)
        ) {
            Storage::disk('public')->delete($dekorasi->foto);
        }

        // Hapus data
        $dekorasi->delete();

        return redirect()
            ->back()
            ->with('success', 'Paket dekorasi berhasil dihapus!');
    }
}