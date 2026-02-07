<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prodi;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Pembayaran;
use Barryvdh\DomPDF\Facade\Pdf;

class PendaftaranController extends Controller
{
    public function pendaftaran()
    {
        $prodis = Prodi::all(); // Ambil semua data prodi
        return view('user.form-pendaftaran', compact('prodis'));
    }

    public function store(Request $request)
    {
        // --- 1. CEK DUPLIKASI ---
        // Cek apakah user ini sudah pernah mendaftar sebelumnya?
        // Kita cek di awal agar tidak perlu validasi input jika memang sudah daftar.
        $cekPendaftaran = Pendaftaran::where('user_id', Auth::id())->first();

        if ($cekPendaftaran) {
            return back()->with('error', 'Anda sudah terdaftar! Tidak bisa mendaftar dua kali.');
        }

        // --- 2. ATURAN VALIDASI (RULES) ---
        $rules = [
            'full_name'           => 'required|string|min:3|max:40',
            'alamat'              => 'required|string|min:10',
            'tempat_lahir'        => 'required|string|max:30',
            'tanggal_lahir'       => 'required|date|before:today', // Harus sebelum hari ini
            'nomor_telepon'       => 'required|numeric|digits_between:10,15', // Hanya angka, 10-15 digit
            'jenis_kelamin'       => 'required|in:L,P',
            'prodi_id'            => 'required|integer|exists:prodis,id', // Wajib ada di tabel prodis
            'pendidikan_terakhir' => 'required|in:SMA,D3,S1',
        ];

        // --- 3. PESAN ERROR KUSTOM (MESSAGES) ---
        $messages = [
            // Nama Lengkap
            'full_name.required' => 'Nama lengkap wajib diisi sesuai KTP.',
            'full_name.min'      => 'Nama lengkap terlalu pendek (minimal 3 karakter).',
            'full_name.max'      => 'Nama lengkap terlalu panjang.',

            // Alamat
            'alamat.required'    => 'Alamat domisili wajib diisi.',
            'alamat.min'         => 'Alamat harus detail (minimal 10 karakter).',

            // Tempat & Tanggal Lahir
            'tempat_lahir.required'  => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date'     => 'Format tanggal lahir tidak valid.',
            'tanggal_lahir.before'   => 'Tanggal lahir tidak valid (tidak boleh hari ini atau masa depan).',

            // Nomor Telepon
            'nomor_telepon.required'       => 'Nomor telepon/WhatsApp wajib diisi.',
            'nomor_telepon.numeric'        => 'Nomor telepon harus berupa angka.',
            'nomor_telepon.digits_between' => 'Nomor telepon minimal 10 digit dan maksimal 15 digit.',

            // Jenis Kelamin
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'       => 'Pilihan jenis kelamin tidak valid (L/P).',

            // Prodi
            'prodi_id.required' => 'Silakan pilih Program Studi tujuan.',
            'prodi_id.exists'   => 'Program studi yang dipilih tidak tersedia di database.',

            // Pendidikan
            'pendidikan_terakhir.required' => 'Pendidikan terakhir wajib dipilih.',
            'pendidikan_terakhir.in'       => 'Jenjang pendidikan tidak valid.',
        ];

        // --- 4. EKSEKUSI VALIDASI ---
        // Jika validasi gagal, Laravel otomatis redirect back dengan errors
        $validatedData = $request->validate($rules, $messages);

        // --- 5. TAMBAHAN DATA OTOMATIS ---
        $validatedData['user_id'] = Auth::id();
        $validatedData['status']  = 'pending';

        // --- 6. SIMPAN DATA ---
        try {
            Pendaftaran::create($validatedData);

            Alert::success('Pendaftaran Berhasil', 'Data Anda telah kami terima dan sedang dalam proses verifikasi.');
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            // Jika ada error database lain yang tidak terduga
            return back()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi nanti.')->withInput();
        }
    }

    public function statusPendaftaran()
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->with('prodi')->first();

        // Ambil data pembayaran jika ada
        $pembayaran = Pembayaran::where('pendaftaran_id', $pendaftaran->id ?? 0)->latest()->first();

        if (!$pendaftaran) {
            return redirect()->route('pendaftaran')->with('error', 'Silakan mendaftar terlebih dahulu.');
        }

        return view('user.status-pendaftaran', compact('pendaftaran', 'pembayaran'));
    }

    public function listPendaftaran(Request $request)
    {
        $query = Pendaftaran::with('prodi'); // Eager load relasi prodi

        // Fitur Pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('full_name', 'LIKE', "%{$search}%")
                ->orWhere('nomor_telepon', 'LIKE', "%{$search}%");
        }

        // Urutkan status: Pending paling atas
        $pendaftarans = $query->orderByRaw("FIELD(status, 'pending', 'verified', 'payment_process', 'accepted', 'rejected')")
            ->latest()
            ->paginate(10);

        return view('admin.list_pendaftaran', compact('pendaftarans'));
    }

    // Method show() akan kita buat selanjutnya jika Anda minta detailnya
    public function show($id)
    {
        $pendaftaran = Pendaftaran::with(['prodi', 'user'])->findOrFail($id);
        return view('admin.detail_pendaftaran', compact('pendaftaran'));
    }

    // Method baru di AdminPendaftaranController
    public function updateStatus(Request $request, $id)
    {
        // 1. Validasi: Pastikan input hanya 'accepted' atau 'rejected'
        $request->validate([
            'status' => 'required|in:accepted,rejected'
        ]);

        // 2. Ambil Data Pendaftaran
        $pendaftaran = Pendaftaran::findOrFail($id);

        // [OPSIONAL] Logika Pengaman:
        // Jika ingin mencegah status yang sudah 'accepted' diubah jadi 'rejected' (atau sebaliknya) secara tidak sengaja.
        // Hapus blok if ini jika Anda ingin Admin bebas gonta-ganti status kapan saja.
        /*
    if ($pendaftaran->status == 'accepted' || $pendaftaran->status == 'rejected') {
        return back()->with('error', 'Status pendaftaran ini sudah final dan tidak dapat diubah lagi.');
    }
    */

        // 3. Update Status
        $pendaftaran->status = $request->status;
        $pendaftaran->save();

        // 4. Siapkan Pesan Notifikasi yang Sesuai
        $pesan = '';

        if ($request->status == 'accepted') {
            $pesan = 'Berhasil: Mahasiswa dinyatakan DITERIMA (Accepted).';

            // [Tambahan Logika] Jika diterima, mungkin Anda ingin melakukan sesuatu lain?
            // Contoh: Kirim Email Notifikasi Lulus (Opsional)
            // Mail::to($pendaftaran->user->email)->send(new MahasiswaDiterima($pendaftaran));

        } elseif ($request->status == 'rejected') {
            $pesan = 'Berhasil: Pendaftaran dinyatakan DITOLAK (Rejected).';
        }

        return back()->with('success', $pesan);
    }

    public function storePembayaran(Request $request)
    {
        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:10000',
            'tanggal_bayar' => 'required|date',
            'metode_pembayaran' => 'required|in:transfer_bank,e_wallet',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->firstOrFail();

        // Upload File
        $path = $request->file('bukti_pembayaran')->store('bukti-bayar', 'public');

        // Simpan ke Database
        Pembayaran::create([
            'pendaftaran_id' => $pendaftaran->id,
            'user_id' => Auth::id(),
            'jumlah_bayar' => $request->jumlah_bayar,
            'tanggal_bayar' => $request->tanggal_bayar,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => 'pending', // Default pending
            'bukti_pembayaran' => $path,
        ]);

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil dikirim. Mohon tunggu verifikasi admin.');
    }

    public function listPembayaran()
    {
        // Ambil data pembayaran, urutkan dari yang terbaru
        // Eager load 'pendaftaran' untuk mengambil nama mahasiswa
        $pembayarans = Pembayaran::with('pendaftaran')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.list_pembayaran', compact('pembayarans'));
    }

    public function updateStatusPembayaran(Request $request, $id)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:verified,rejected',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);

        $pembayaran->update([
            'status_pembayaran' => $request->status_pembayaran
        ]);

        $statusMsg = $request->status_pembayaran == 'verified' ? 'diterima' : 'ditolak';

        return redirect()->back()->with('success', "Pembayaran berhasil $statusMsg.");
    }

    public function cetakKartu()
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->with('prodi')->first();
        $pembayaran = Pembayaran::where('pendaftaran_id', $pendaftaran->id)->latest()->first();

        // Validasi Keamanan: Hanya yang sudah LULUS dan BAYAR yang boleh cetak
        if (!$pendaftaran || $pendaftaran->status != 'accepted' || !$pembayaran || $pembayaran->status_pembayaran != 'verified') {
            return redirect()->back()->with('error', 'Anda belum memenuhi syarat untuk mencetak kartu.');
        }

        // Load View PDF
        $pdf = Pdf::loadView('user.ktm_sementara', compact('pendaftaran'));

        // Set ukuran kertas (A4) dan orientasi (Potrait)
        $pdf->setPaper('A4', 'portrait');

        // Stream (tampilkan di browser) atau Download
        return $pdf->stream('KTM_Sementara_' . $pendaftaran->full_name . '.pdf');
    }

    public function cetakDetail($id)
    {
        // Ambil data pendaftaran beserta relasi (User, Prodi, Pembayaran)
        $pendaftaran = Pendaftaran::with(['user', 'prodi'])->findOrFail($id);

        // Ambil data pembayaran terakhir (opsional, untuk ditampilkan di PDF)
        $pembayaran = Pembayaran::where('pendaftaran_id', $id)->latest()->first();

        $pdf = Pdf::loadView('admin.cetak_pendaftaran', compact('pendaftaran', 'pembayaran'));

        // Set ukuran kertas A4 Portrait
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Detail_Pendaftaran_' . $pendaftaran->id . '.pdf');
    }
}
