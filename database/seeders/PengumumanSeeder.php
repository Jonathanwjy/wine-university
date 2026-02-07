<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengumumans')->insert([
            [
                'judul' => 'Libur Akhir Semester Ganjil',
                'tagline' => 'Jadwal Libur Semester Ganjil 2025/2026',
                'isi' => 'Diberitahukan kepada seluruh mahasiswa dan staf, bahwa libur akhir semester ganjil akan dimulai dari tanggal 20 Desember 2025 hingga 3 Januari 2026.',
                'tanggal_dibuat' => Carbon::now()->subDays(5)->format('Y-m-d'), // 5 hari yang lalu
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'judul' => 'Pendaftaran Semester Genap Dibuka',
                'tagline' => 'Mulai Isi KRS untuk Semester Genap',
                'isi' => 'Pendaftaran Kartu Rencana Studi (KRS) untuk semester genap 2025/2026 dibuka mulai hari Senin, 6 Januari 2026. Harap segera mengisi KRS sebelum batas waktu.',
                'tanggal_dibuat' => Carbon::now()->subDays(10)->format('Y-m-d'), // 10 hari yang lalu
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'judul' => 'Workshop Penulisan Skripsi',
                'tagline' => 'Workshop wajib bagi mahasiswa tingkat akhir',
                'isi' => 'Fakultas Teknologi mengadakan workshop penulisan skripsi pada tanggal 15 Januari 2026 di Aula Utama. Diharapkan kehadiran seluruh mahasiswa yang akan mengajukan skripsi.',
                'tanggal_dibuat' => Carbon::now()->subDays(2)->format('Y-m-d'), // 2 hari yang lalu
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'judul' => 'Penggantian Jam Kuliah Umum',
                'tagline' => 'Perubahan Jadwal Mata Kuliah Dasar',
                'isi' => 'Mata Kuliah Dasar Statistika yang seharusnya dilaksanakan hari Rabu, diubah menjadi hari Kamis pukul 10.00-12.00 di ruangan yang sama. Harap diperhatikan.',
                'tanggal_dibuat' => Carbon::now()->format('Y-m-d'), // Hari ini
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
