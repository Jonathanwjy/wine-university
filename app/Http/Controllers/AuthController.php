<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function register_post(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|required_with:password|same:password|min:8',
            'role' => 'required|in:admin,user',
        ], [
            // Custom error messages
            'email.required' => 'Email harus diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'email.email' => 'Harap masukkan email yang valid dengan @.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password harus terdiri dari minimal 8 karakter.',
            'confirm_password.required' => 'Konfirmasi password harus diisi.',
            'confirm_password.same' => 'Konfirmasi password tidak cocok dengan password.',
            'confirm_password.min' => 'Konfirmasi password harus terdiri dari minimal 8 karakter.',
        ]);

        // Menyimpan data pengguna baru
        $user = new User();
        $user->email = trim($request->email);
        $user->password = Hash::make(trim($request->password));
        $user->role = trim($request->role);
        $user->save();

        Alert::success('Registrasi Berhasil', 'tunggu konfirmasi dari admin untuk mengaktifkan akun Anda.');
        return redirect('/');
    }


    public function login_post(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $request->session()->regenerate();
            $user = Auth::user();

            // 1. Cek Admin
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            // 2. Cek User
            if ($user->role === 'user') {
                if ($user->status === 'pending') {
                    return redirect()->route('account.pending');
                }

                if ($user->status === 'inactive') {
                    return redirect()->route('account.pending');
                }

                return redirect()->intended('/');
            }

            Auth::logout();
            return back()->withErrors(['email' => 'Role akun tidak dikenali.']);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }


    public function logout()
    {
        Auth::logout();
        return redirect(url('/login'));
    }

    public function kelolaUser()
    {
        $users = User::where('role', 'user')
            ->orderByRaw("FIELD(status, 'pending', 'active', 'rejected')")
            ->latest() // Kemudian urutkan berdasarkan yang paling baru daftar
            ->paginate(10); // Batasi 10 per halaman

        // 3. Hitung jumlah untuk Badge di atas tabel
        $countPending = User::where('role', 'user')->where('status', 'pending')->count();
        $countActive = User::where('role', 'user')->where('status', 'active')->count();

        return view('admin.daftar_user', compact('users', 'countPending', 'countActive'));
    }
    public function updateStatus(Request $request, $id)
    {
        // 1. Validasi Input (Menerima active, inactive, atau pending)
        $request->validate([
            'status' => 'required|in:active,inactive,pending'
        ]);

        // 2. Cari User
        $user = User::findOrFail($id);

        // 3. Pencegahan: Jangan biarkan Admin mengubah status akun sendiri
        if ($user->id == Auth::id()) {
            return back()->with('error', 'Anda tidak dapat mengubah status akun Anda sendiri.');
        }

        // 4. Simpan Status Baru
        $user->status = $request->status;
        $user->save();

        // 5. Tentukan Pesan Notifikasi
        $message = 'Status pengguna berhasil diperbarui.';

        if ($request->status == 'active') {
            // Pesan jika diterima
            $message = 'Verifikasi Berhasil: Akun diterima dan status menjadi ACTIVE.';
        } elseif ($request->status == 'inactive') {
            // Pesan jika ditolak (Langsung dianggap ditolak/inactive)
            $message = 'Verifikasi Ditolak: Akun telah diubah menjadi INACTIVE (Ditolak).';
        } elseif ($request->status == 'pending') {
            // Opsional: Jika dikembalikan ke pending
            $message = 'Status akun dikembalikan menjadi PENDING.';
        }

        return back()->with('success', $message);
    }
}
