<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PengumumanController;
use Illuminate\Support\Facades\Auth;


Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('login_post', [AuthController::class, 'login_post'])->name('login_post');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('register_post', [AuthController::class, 'register_post'])->name('register_post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/detail_pengumuman/{id}', [PengumumanController::class, 'detailPengumuman'])->name('detail_pengumuman');

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');

    //pengumuman routes
    Route::get('/admin/kelola-pengumuman', [PengumumanController::class, 'adminPengumuman'])->name('admin.pengumuman');
    Route::get('/admin/add-pengumuman', [PengumumanController::class, 'addPengumuman'])->name('pengumuman.add');
    Route::get('/admin/edit-pengumuman/{id}', [PengumumanController::class, 'editPengumuman'])->name('pengumuman.edit');
    Route::put('/admin/pengumuman-update/{id}', [PengumumanController::class, 'update'])->name('pengumuman.update');
    Route::get('/admin/pengumuman-show/{id}', [PengumumanController::class, 'show'])->name('pengumuman.show');
    Route::post('/admin/pengumuman-store', [PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::get('/admin/pengumuman-delete/{id}', [PengumumanController::class, 'destroy'])->name('pengumuman.delete');

    //verifikasi users
    Route::get('/admin/kelola-user', [AuthController::class, 'kelolaUser'])->name('admin.kelola_user');
    Route::patch('/users-status/{id}', [AuthController::class, 'updateStatus'])->name('admin.users.update_status');
    Route::get('admin/pendaftaran-list', [PendaftaranController::class, 'listPendaftaran'])->name('admin.list_pendaftaran');


    Route::patch('/pendaftaran-status/{id}', [PendaftaranController::class, 'updateStatus'])
        ->name('admin.pendaftaran.update_status');
    Route::get('/pendaftaran-detail/{id}', [PendaftaranController::class, 'show'])->name('admin.detail_pendaftaran');

    Route::get('admin/pembayaran-list', [PendaftaranController::class, 'listPembayaran'])->name('admin.list_pembayaran');
    Route::patch('/pembayaran/{id}/update', [PendaftaranController::class, 'updateStatusPembayaran'])->name('admin.pembayaran.update_status');

    Route::get('/pendaftaran/{id}/cetak', [PendaftaranController::class, 'cetakDetail'])->name('pendaftaran.cetak');
});



Route::middleware(['auth'])->get('/account-pending', function () {
    // Keamanan Ganda: Jika user ternyata sudah active tapi coba akses halaman ini, lempar ke dashboard
    if (Auth::user()->status == 'active') {
        return redirect('/user/dashboard'); // sesuaikan dengan dashboard user Anda
    }
    return view('user.statusdaftar');
})->name('account.pending');


// Bungkus route dashboard user dengan middleware 'is_active'
Route::middleware(['auth', 'is_active'])->group(function () {
    Route::get('/user/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('/pendaftaran', [PendaftaranController::class, 'pendaftaran'])->name('pendaftaran');
    Route::post('/pendaftaran-store', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

    Route::get('/status-pendaftaran', [PendaftaranController::class, 'statusPendaftaran'])->name('status.pendaftaran');
    Route::post('/bayar-pendaftaran', [PendaftaranController::class, 'storePembayaran'])->name('simpan.pembayaran');

    Route::get('/cetak-kartu', [PendaftaranController::class, 'cetakKartu'])->name('cetak.kartu');
    // route user lainnya...
});
