<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Dekorasi;
use App\Models\Booking;
use App\Models\Pembayaran;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // <-- Tambahkan facade Storage jika diperlukan untuk hapus/kelola foto

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

        // Ambil harga berdasarkan tipe
        if ($request->tipe == 'dekorasi') {
            $item = Dekorasi::findOrFail($request->id_item);
            $harga = $item->harga;
        } else {
            $item = Layanan::findOrFail($request->id_item);
            $harga = $item->harga;
        }

        // Simpan booking menggunakan ID user yang sedang login
        Booking::create([
            'kode_booking' => 'AMR' . rand(100, 999),
            'id_user' => Auth::id(), // <-- Mengambil ID user dari session yang aktif
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
        $bookings = Booking::with('pembayarans')
            ->where('id_user', Auth::id())
            ->latest()
            ->get();

        return view('riwayat', compact('bookings'));
    }

    // Method untuk proses upload bukti pembayaran
    public function uploadPembayaran(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $booking = Booking::findOrFail($id);

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_' . $booking->kode_booking . '.' . $file->getClientOriginalExtension();
            
            // Simpan gambar ke folder storage/app/public/bukti_pembayaran
            $file->storeAs('bukti_pembayaran', $filename, 'public');

            // Simpan record ke tabel pembayarans
            Pembayaran::create([
                'id_booking' => $booking->id_booking,
                'jumlah_bayar' => $booking->total_harga,
                'metode_pembayaran' => 'Transfer',
                'jenis_pembayaran' => 'DP',
                'bukti_pembayaran' => $filename,
                'tanggal_bayar' => now(),
                'status_pembayaran' => 'Pending',
            ]);

            // Update status booking
            $booking->update([
                'status_booking' => 'Menunggu',
            ]);
        }

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload! Menunggu verifikasi admin.');
    }

    // =========================================================================
    // TAMBAHKAN CONTOH METHOD INI JIKA ANDA INGIN MENYIMPAN LAYANAN/DEKORASI + FOTO
    // (Sesuaikan dengan Controller tempat Anda mengelola data Layanan/Dekorasi)
    // =========================================================================
    public function storeLayananAtauDekorasi(Request $request)
    {
       if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            $namaFileFoto = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('layanan', $namaFileFoto, 'public');

            $namaFileFoto = 'layanan/' . $namaFileFoto;
        }

        Layanan::create([
            'nama_layanan' => $request->nama_layanan,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'durasi' => $request->durasi,
            'deskripsi' => $request->deskripsi,
            'foto' => $namaFileFoto,
        ]);

        return redirect()->back()->with('success', 'Layanan dan foto berhasil ditambahkan!');
    }
}