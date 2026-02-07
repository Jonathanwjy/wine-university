@extends('template.navbar')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto space-y-8">

        {{-- HEADER SECTION --}}
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">
                Status Pendaftaran
            </h2>
            <p class="mt-3 max-w-2xl mx-auto text-lg text-gray-500">
                Pantau progres seleksi dan administrasi pendaftaran Anda di sini.
            </p>
        </div>

        {{-- ALERT MESSAGE (SESSION) --}}
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex justify-between items-center">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
            <button @click="show = false" class="text-green-500 hover:text-green-700">
                <span class="sr-only">Close</span>
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
        @endif

        {{-- LOGIKA UTAMA --}}

        {{-- KONDISI 1: PENDAFTARAN DITOLAK --}}
        @if($pendaftaran->status == 'rejected')
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-red-500">
            <div class="p-8 text-center">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-100 mb-6">
                    <svg class="h-10 w-10 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">Pendaftaran Ditolak</h3>
                <p class="mt-4 text-gray-600 max-w-lg mx-auto">
                    Mohon maaf, data pendaftaran Anda belum memenuhi kriteria kami saat ini. Tetap semangat dan jangan menyerah.
                </p>
            </div>
        </div>

        {{-- KONDISI 2: PENDAFTARAN PENDING (Menunggu Review Admin) --}}
        @elseif($pendaftaran->status == 'pending')
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-yellow-400">
            <div class="p-8 text-center">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-yellow-100 mb-6 animate-pulse">
                    <svg class="h-10 w-10 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">Menunggu Verifikasi</h3>
                <p class="mt-4 text-gray-600 max-w-lg mx-auto">
                    Data diri Anda sedang dalam proses peninjauan oleh Admin. Mohon periksa halaman ini secara berkala untuk pembaruan status.
                </p>
            </div>
        </div>

        {{-- KONDISI 3: PENDAFTARAN DITERIMA (ACCEPTED) --}}
        @elseif($pendaftaran->status == 'accepted')

        {{-- A. JIKA SUDAH BAYAR & STATUS VERIFIED (LULUS RESMI) --}}
        @if($pembayaran && $pembayaran->status_pembayaran == 'verified')
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-green-200">
            <div class="bg-green-600 px-4 py-8 sm:px-10 text-center">
                <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-white mb-6 shadow-lg">
                    <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-3xl font-extrabold text-white tracking-wide uppercase">Selamat! Anda Lulus</h3>
                <p class="mt-2 text-green-100 font-medium text-lg">
                    Selamat datang mahasiswa program studi <br> <span class="font-bold text-white">{{ $pendaftaran->prodi->nama_prodi }}</span>
                </p>
            </div>
            <div class="px-8 py-8 bg-gray-50 text-center">
                <div class="mt-8 flex justify-center gap-4">
                    <a href="{{ route('cetak.kartu') }}" target="_blank" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download KTM Sementara (PDF)
                    </a>
                </div>
            </div>
        </div>

        {{-- B. JIKA SUDAH BAYAR & STATUS PENDING (Menunggu Validasi Bayar) --}}
        @elseif($pembayaran && $pembayaran->status_pembayaran == 'pending')
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-blue-500">
            <div class="p-6 sm:p-10 flex flex-col sm:flex-row items-start sm:items-center bg-blue-50">
                <div class="flex-shrink-0 mb-4 sm:mb-0 sm:mr-6">
                    <div class="h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-blue-900">Pembayaran Sedang Divalidasi</h3>
                    <p class="mt-2 text-blue-700 leading-relaxed">
                        Terima kasih telah melakukan pembayaran. Tim keuangan kami sedang memverifikasi bukti transfer Anda. Status kelulusan akan otomatis diperbarui setelah validasi selesai.
                    </p>
                    <p class="mt-3 text-sm text-blue-500 font-medium">
                        <span class="inline-block bg-blue-200 text-blue-800 px-2 py-1 rounded">Diunggah: {{ \Carbon\Carbon::parse($pembayaran->created_at)->format('d M Y, H:i') }} WIB</span>
                    </p>
                </div>
            </div>
        </div>

        {{-- C. JIKA BELUM BAYAR ATAU PEMBAYARAN DITOLAK (Form Muncul) --}}
        @else

        <div class="space-y-8">

            {{-- Hero Section: Diterima --}}
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl shadow-lg p-6 sm:p-10 text-white relative overflow-hidden">
                <div class="relative z-10 flex flex-col sm:flex-row items-center">
                    <div class="p-3 bg-white/20 rounded-full mr-0 sm:mr-6 mb-4 sm:mb-0">
                        <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-center sm:text-left">
                        <h3 class="text-2xl font-bold">Selamat {{ $pendaftaran->full_name }}!</h3>
                        <p class="mt-2 text-green-50 text-lg">Pendaftaran Anda telah <strong>DITERIMA</strong>. Silakan lengkapi langkah terakhir dengan melakukan pembayaran registrasi ulang.</p>
                    </div>
                </div>
                {{-- Dekorasi background --}}
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
            </div>

            {{-- Alert Error jika pembayaran ditolak --}}
            @if($pembayaran && $pembayaran->status_pembayaran == 'rejected')
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm">
                <div class="flex">
                    <div class="">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Pembayaran Ditolak</h3>
                        <div class="mt-1 text-sm text-red-700">
                            Bukti pembayaran sebelumnya tidak valid atau tidak terbaca. Silakan upload ulang bukti yang benar.
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- FORM CARD --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-6 bg-gray-50 border-b border-gray-100">
                    <h3 class="text-lg leading-6 font-bold text-gray-900">Formulir Konfirmasi Pembayaran</h3>
                    <p class="mt-1 text-sm text-gray-500">Isi detail pembayaran Anda di bawah ini.</p>
                </div>

                <div class="p-6 sm:p-8">
                    <form action="{{ route('simpan.pembayaran') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                            {{-- Input Jumlah Bayar --}}
                            <div class="col-span-1 sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nominal yang Harus Dibayar</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-lg font-bold">Rp</span>
                                    </div>
                                    <input type="number" name="jumlah_bayar" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-12 py-3 sm:text-lg border-gray-300 rounded-md bg-gray-100 font-bold text-gray-800 cursor-not-allowed" placeholder="0.00" value="35000000" readonly>
                                </div>
                                <p class="mt-1 text-xs text-gray-400">*Nominal otomatis ditetapkan oleh sistem.</p>
                            </div>

                            {{-- Input Tanggal Bayar --}}
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembayaran</label>
                                <input type="date" name="tanggal_bayar" class="focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md py-2.5 px-3">
                            </div>

                            {{-- Input Metode --}}
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                                <select name="metode_pembayaran" class="focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md py-2.5 px-3">
                                    <option value="transfer_bank">Transfer Bank</option>
                                    <option value="e_wallet">E-Wallet (GoPay/OVO/Dana)</option>
                                </select>
                            </div>

                            {{-- Input File (Custom Style) --}}
                            <div class="col-span-1 sm:col-span-2 mt-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Transfer</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-50 transition-colors group">
                                    <div class="space-y-1 text-center relative">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-blue-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Upload file</span>
                                                {{-- Input file tersembunyi tapi tetap berfungsi --}}
                                                <input id="file-upload" name="bukti_pembayaran" type="file" accept="image/*" class="sr-only">
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 2MB</p>
                                    </div>
                                </div>
                                {{-- Pesan error file --}}
                                @error('bukti_pembayaran')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                                {{-- JS Sederhana untuk menampilkan nama file yang dipilih (Opsional, UI enhancement) --}}
                                <div id="file-name-display" class="mt-2 text-sm text-gray-600 italic hidden"></div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:-translate-y-0.5">
                                Kirim Bukti Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Script kecil untuk menampilkan nama file saat user memilih file --}}
        <script>
            document.getElementById('file-upload').addEventListener('change', function() {
                var fileName = this.files[0] ? this.files[0].name : "Belum ada file dipilih";
                var display = document.getElementById('file-name-display');
                display.textContent = 'File terpilih: ' + fileName;
                display.classList.remove('hidden');
            });
        </script>

        @endif
        @endif
    </div>
</div>
@endsection