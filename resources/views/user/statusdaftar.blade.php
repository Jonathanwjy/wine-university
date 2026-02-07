<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Status Akun</title>
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">

    <div class="max-w-lg w-full bg-white rounded-xl shadow-2xl overflow-hidden border border-gray-100">

        {{-- BAGIAN HEADER --}}
        @if(Auth::user()->status == 'pending')
        {{-- Header Kuning untuk Pending --}}
        <div class="bg-yellow-600 p-6 text-center text-white">
            <h2 class="text-xl font-bold tracking-tight">Menunggu Verifikasi</h2>
            <p class="text-yellow-100 text-sm mt-1">{{ Auth::user()->email }}</p>
        </div>
        @else
        {{-- Header Merah untuk Inactive/Ditolak --}}
        <div class="bg-red-600 p-6 text-center text-white">
            <h2 class="text-xl font-bold tracking-tight">Akses Ditolak</h2>
            <p class="text-red-100 text-sm mt-1">{{ Auth::user()->email }}</p>
        </div>
        @endif

        <div class="p-8 text-center">

            {{-- KONDISI 1: STATUS PENDING --}}
            @if(Auth::user()->status == 'pending')

            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-yellow-100 mb-6 animate-pulse">
                <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <h3 class="text-2xl font-bold text-gray-800 mb-2">Akun Sedang Ditinjau</h3>
            <p class="text-gray-500 mb-6">
                Terima kasih telah login. Saat ini pendaftaran akun Anda masih dalam antrean verifikasi Admin.
                Mohon tunggu hingga status berubah menjadi aktif.
            </p>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-8 text-left">
                <p class="text-sm text-yellow-800 font-semibold">Apa yang harus saya lakukan?</p>
                <ul class="list-disc list-inside text-sm text-yellow-700 mt-1">
                    <li>Cek halaman ini secara berkala.</li>
                    <li>Hubungi Admin Kampus jika proses lebih dari 24 jam.</li>
                </ul>
            </div>

            {{-- KONDISI 2: STATUS INACTIVE (DITOLAK) --}}
            @elseif(Auth::user()->status == 'inactive')

            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-red-100 mb-6">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <h3 class="text-2xl font-bold text-gray-800 mb-2">Akun Dinonaktifkan</h3>
            <p class="text-gray-500 mb-6">
                Mohon maaf, pendaftaran akun Anda <strong>Ditolak</strong> atau akun Anda telah <strong>Dinonaktifkan</strong> oleh Administrator.
                Anda tidak dapat mengakses sistem ini.
            </p>

            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-8 text-left">
                <p class="text-sm text-red-800 font-semibold">Penyebab umum penolakan:</p>
                <ul class="list-disc list-inside text-sm text-red-700 mt-1">
                    <li>Data pendaftaran tidak valid atau tidak lengkap.</li>
                    <li>Anda tidak memenuhi syarat pendaftaran.</li>
                    <li>Silakan hubungi bagian administrasi untuk info lebih lanjut.</li>
                </ul>
            </div>

            @endif

            {{-- TOMBOL LOGOUT (Sama untuk kedua kondisi) --}}
            <form action="{{ route('logout') }}" method="GET">
                @csrf
                <button type="submit" class="w-full text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:ring-gray-50 font-bold rounded-lg text-sm px-5 py-3 focus:outline-none transition flex justify-center items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Keluar (Logout)
                </button>
            </form>

        </div>
    </div>

</body>

</html>