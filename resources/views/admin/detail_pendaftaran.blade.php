@extends('admin.sidebar')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="p-4 min-h-screen bg-gray-50">

    {{-- Header & Breadcrumb --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <nav class="flex mb-1" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm">
                    <li><a href="{{ route('admin.list_pendaftaran') }}" class="text-gray-500 hover:text-blue-600">Pendaftaran</a></li>
                    <li><span class="text-gray-400">/</span></li>
                    <li class="text-gray-700 font-medium">Detail #{{ $pendaftaran->id }}</li>
                </ol>
            </nav>
            <h2 class="text-2xl font-bold text-gray-900">Detail Calon Mahasiswa</h2>
        </div>
        <a href="{{ route('admin.list_pendaftaran') }}" class="text-gray-500 hover:text-gray-700 font-medium text-sm flex items-center bg-white border border-gray-300 px-4 py-2 rounded-lg shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    @if(session('success'))
    <div id="success-message" data-message="{{ session('success') }}"></div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- KOLOM KIRI: DATA LENGKAP --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Kartu Data Pribadi --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800">Informasi Pribadi</h3>
                    <span class="text-xs text-gray-500">Terdaftar: {{ $pendaftaran->created_at->format('d M Y H:i') }}</span>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Nama Lengkap</p>
                            <p class="font-semibold text-gray-900 text-lg">{{ $pendaftaran->full_name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Email Akun</p>
                            <p class="font-medium text-gray-700">{{ $pendaftaran->user->email ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Tempat, Tanggal Lahir</p>
                            <p class="font-medium text-gray-700">
                                {{ $pendaftaran->tempat_lahir }}, {{ \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->translatedFormat('d F Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Jenis Kelamin</p>
                            <p class="font-medium text-gray-700">
                                {{ $pendaftaran->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Nomor Telepon / WA</p>
                            <p class="font-medium text-gray-700 flex items-center">
                                <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                </svg>
                                {{ $pendaftaran->nomor_telepon }}
                            </p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Alamat Domisili</p>
                            <p class="font-medium text-gray-700 leading-relaxed">{{ $pendaftaran->alamat }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kartu Data Akademik --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="font-bold text-gray-800">Data Akademik</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Program Studi Pilihan</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-blue-50 text-blue-700 mt-1 border border-blue-100">
                                {{ $pendaftaran->prodi->nama_prodi ?? 'Tidak Diketahui' }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Jenjang</p>
                            <p class="font-medium text-gray-700">S1 (Sarjana)</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Pendidikan Terakhir</p>
                            <p class="font-medium text-gray-700">{{ $pendaftaran->pendidikan_terakhir }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- KOLOM KANAN: STATUS & AKSI --}}
        <div class="lg:col-span-1 space-y-6">

            {{-- Kartu Status --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                <p class="text-sm text-gray-500 mb-2">Status Saat Ini</p>

                @if($pendaftaran->status == 'accepted')
                <div class="inline-flex flex-col items-center">
                    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-green-700">DITERIMA</span>
                </div>
                @elseif($pendaftaran->status == 'pending')
                <div class="inline-flex flex-col items-center">
                    <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mb-3 animate-pulse">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-yellow-700">PENDING</span>
                    <p class="text-xs text-yellow-600 mt-1">Menunggu Keputusan Admin</p>
                </div>
                @elseif($pendaftaran->status == 'rejected')
                <div class="inline-flex flex-col items-center">
                    <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-red-700">DITOLAK</span>
                </div>
                @endif
            </div>

            {{-- Kartu Aksi Admin --}}
            {{-- Kartu Aksi Admin --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="font-bold text-gray-800 mb-4">Tindakan Admin</h3>

                <div class="space-y-3">

                    {{-- KONDISI 1: JIKA STATUS PENDING --}}
                    @if($pendaftaran->status == 'pending')

                    <form action="{{ route('admin.pendaftaran.update_status', $pendaftaran->id) }}" method="POST" class="w-full form-reject">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="accepted">
                        <button type="button" class="btn-accept w-full text-green-600 bg-white border border-green-200 hover:bg-green-50 font-medium rounded-lg text-sm px-5 py-3 text-center flex items-center justify-center transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Terima Pendaftaran
                        </button>
                    </form>

                    <form action="{{ route('admin.pendaftaran.update_status', $pendaftaran->id) }}" method="POST" class="w-full form-reject">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="rejected">
                        <button type="button" class="btn-reject w-full text-red-600 bg-white border border-red-200 hover:bg-red-50 font-medium rounded-lg text-sm px-5 py-3 text-center flex items-center justify-center transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Tolak Pendaftaran
                        </button>
                    </form>

                    {{-- KONDISI 2: JIKA STATUS ACCEPTED --}}
                    @elseif($pendaftaran->status == 'accepted')
                    <div class="text-center p-3 bg-green-50 text-green-700 text-sm rounded border border-green-200 font-medium">
                        Mahasiswa Resmi Diterima.
                    </div>

                    {{-- Tombol Batalkan Kelulusan --}}
                    <form action="{{ route('admin.pendaftaran.update_status', $pendaftaran->id) }}" method="POST" class="w-full mt-2">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="rejected">
                        <button type="button" class="btn-reject text-xs text-red-500 hover:text-red-700 hover:underline w-full text-center p-2">
                            Batalkan / Tolak Kembali
                        </button>
                    </form>

                    {{-- KONDISI 3: JIKA STATUS REJECTED (DITOLAK) --}}
                    @else
                    <div class="text-center p-3 bg-red-50 text-red-700 text-sm rounded border border-red-200 font-medium mb-3">
                        Pendaftaran Telah Ditolak.
                    </div>

                    {{-- FITUR BARU: TOMBOL TERIMA KEMBALI --}}
                    <form action="{{ route('admin.pendaftaran.update_status', $pendaftaran->id) }}" method="POST" class="w-full">
                        @csrf @method('PATCH')
                        {{-- Mengubah status kembali menjadi accepted --}}
                        <input type="hidden" name="status" value="accepted">

                        {{-- Perhatikan class 'btn-accept' tetap ada agar alert JS muncul --}}
                        <button type="button" class="btn-accept w-full text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-3 text-center flex items-center justify-center transition shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Tinjau & Terima Kembali
                        </button>
                    </form>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Alert Sukses
        const successMessage = document.getElementById("success-message");
        if (successMessage) {
            Swal.fire({
                title: "Berhasil!",
                text: successMessage.dataset.message,
                icon: "success",
                timer: 2000,
                showConfirmButton: false
            });
        }

        // Konfirmasi Tolak
        const rejectButtons = document.querySelectorAll(".btn-reject");
        rejectButtons.forEach((btn) => {
            btn.addEventListener("click", function(e) {
                e.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    title: "Tolak Pendaftaran?",
                    text: "Calon mahasiswa akan ditandai sebagai tidak lulus.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, Tolak",
                    cancelButtonText: "Batal",
                    confirmButtonColor: "#EF4444",
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

        const acceptButtons = document.querySelectorAll(".btn-accept");

        acceptButtons.forEach((btn) => {
            btn.addEventListener("click", function(e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: "Terima Pendaftaran?",
                    text: "Mahasiswa akan dinyatakan LULUS dan status menjadi Diterima.",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Ya, Terima",
                    cancelButtonText: "Batal",
                    confirmButtonColor: "#10B981", // Warna Hijau
                    cancelButtonColor: "#6B7280", // Warna Abu-abu
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

    });
</script>

@endsection