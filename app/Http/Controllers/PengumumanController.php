<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PengumumanController extends Controller
{
    public function detailPengumuman($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('detail_pengumuman', compact('pengumuman'));
    }

    public function adminPengumuman()
    {
        $pengumumans = Pengumuman::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.pengumuman', compact('pengumumans'));
    }

    public function show($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('admin.detail_pengumuman', compact('pengumuman'));
    }

    public function addPengumuman()
    {
        return view('admin.add_pengumuman');
    }

    public function editPengumuman($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('admin.edit_pengumuman', compact('pengumuman'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input (Gayanya disamakan dengan register_post)
        $request->validate([
            'judul'          => 'required|max:100',
            'tagline'        => 'required|max:200',
            'isi'            => 'required',
            'tanggal_dibuat' => 'required|date',
        ], [
            // Custom error messages (Bahasa Indonesia)
            'judul.required'          => 'Judul pengumuman harus diisi.',
            'judul.max'               => 'Judul terlalu panjang, maksimal 100 karakter.',
            'tagline.required'        => 'Tagline harus diisi.',
            'tagline.max'             => 'Tagline terlalu panjang, max 200 karakter.',
            'tanggal_dibuat.date'      => 'Format tanggal tidak valid.',
            'isi.required'            => 'Isi pengumuman tidak boleh kosong.',
            'tanggal_dibuat.required' => 'Tanggal publikasi harus dipilih.',
        ]);

        // 2. Menyimpan Data (Manual Instantiation seperti User)
        $pengumuman = new Pengumuman();

        // Menggunakan trim() untuk menghapus spasi di awal/akhir string
        $pengumuman->judul          = trim($request->judul);
        $pengumuman->tagline        = trim($request->tagline);
        $pengumuman->isi            = trim($request->isi);
        $pengumuman->tanggal_dibuat = trim($request->tanggal_dibuat);

        $pengumuman->save();

        // 3. Tampilkan Notifikasi & Redirect
        Alert::success('Berhasil', 'Pengumuman baru telah berhasil diterbitkan.');
        return to_route('admin.pengumuman');
    }

    public function update(Request $request, $id)
    {
        // 1. Validasi Input (Sama persis dengan saat create/register)
        $request->validate([
            'judul'          => 'required|max:100',
            'tagline'        => 'required|max:200',
            'isi'            => 'required',
            'tanggal_dibuat' => 'required|date',
        ], [
            // Custom error messages (Bahasa Indonesia)
            'judul.required'          => 'Judul pengumuman harus diisi.',
            'judul.max'               => 'Judul terlalu panjang, maksimal 100 karakter.',
            'tagline.required'        => 'Tagline harus diisi.',
            'tagline.max'             => 'Tagline terlalu panjang, max 200 karakter.',
            'tanggal_dibuat.date'      => 'Format tanggal tidak valid.',
            'isi.required'            => 'Isi pengumuman tidak boleh kosong.',
            'tanggal_dibuat.required' => 'Tanggal publikasi harus dipilih.',
        ]);

        // 2. Mengambil data lama dari database
        $pengumuman = Pengumuman::findOrFail($id);

        // 3. Update data (Menggunakan cara manual seperti register_post)
        $pengumuman->judul          = trim($request->judul);
        $pengumuman->tagline        = trim($request->tagline);
        $pengumuman->isi            = trim($request->isi);
        $pengumuman->tanggal_dibuat = trim($request->tanggal_dibuat);

        // Simpan perubahan
        $pengumuman->save();

        // 4. Notifikasi dan Redirect
        Alert::success('Berhasil Diupdate', 'Data pengumuman telah berhasil diperbarui.');
        return to_route('admin.pengumuman');
    }

    public function destroy($id)
    {
        Pengumuman::find($id)->delete();
        return redirect()->back()->with('success_delete', 'Pengumuman Berhasil dihapus');
    }
}
