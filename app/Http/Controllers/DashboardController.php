<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\Prodi;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $pengumumans = Pengumuman::latest()->take(4)->get();
        $prodis = Prodi::all(); // Ambil semua data prodi

        return view('dashboard', compact('pengumumans', 'prodis'));
    }

    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    public function userDashboard()
    {
        return view('user.dashboard');
    }
}
