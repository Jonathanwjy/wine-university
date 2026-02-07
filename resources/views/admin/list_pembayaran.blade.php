@extends('admin.sidebar') {{-- Sesuaikan dengan layout admin Anda --}}

@section('content')

{{-- Script SweetAlert & Modal --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div class="p-6 bg-gray-50 min-h-screen">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Verifikasi Pembayaran</h2>
            <p class="text-gray-500 text-sm">Validasi bukti transfer calon mahasiswa.</p>
        </div>
    </div>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
            timer: 2000,
            showConfirmButton: false
        });
    </script>
    @endif

    {{-- Tabel Pembayaran --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th scope="col" class="px-6 py-4">Mahasiswa</th>
                        <th scope="col" class="px-6 py-4">Tanggal & Metode</th>
                        <th scope="col" class="px-6 py-4">Nominal</th>
                        <th scope="col" class="px-6 py-4">Bukti</th>
                        <th scope="col" class="px-6 py-4">Status</th>
                        <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pembayarans as $bayar)
                    <tr class="hover:bg-gray-50 transition">
                        {{-- Kolom Mahasiswa --}}
                        <td class="px-6 py-4 font-medium text-gray-900">
                            <div class="flex flex-col">
                                <span class="text-base font-semibold">{{ $bayar->pendaftaran->full_name ?? 'User Hapus' }}</span>
                                <span class="text-xs text-gray-500">ID: #{{ $bayar->pendaftaran_id }}</span>
                            </div>
                        </td>

                        {{-- Kolom Tanggal --}}
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span>{{ \Carbon\Carbon::parse($bayar->tanggal_bayar)->format('d M Y') }}</span>
                                <span class="text-xs text-gray-400 capitalize">{{ str_replace('_', ' ', $bayar->metode_pembayaran) }}</span>
                            </div>
                        </td>

                        {{-- Kolom Nominal --}}
                        <td class="px-6 py-4 font-semibold text-gray-700">
                            Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}
                        </td>

                        {{-- Kolom Bukti (Tombol Lihat) --}}
                        <td class="px-6 py-4" x-data>
                            <button @click="$dispatch('open-modal', { img: '{{ asset('storage/'.$bayar->bukti_pembayaran) }}' })"
                                class="text-blue-600 hover:text-blue-800 text-xs font-medium border border-blue-200 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded-full transition">
                                <i class="fas fa-eye mr-1"></i> Lihat Bukti
                            </button>
                        </td>

                        {{-- Kolom Status --}}
                        <td class="px-6 py-4">
                            @if($bayar->status_pembayaran == 'pending')
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded border border-yellow-200">Pending</span>
                            @elseif($bayar->status_pembayaran == 'verified')
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-200">Lunas/Verified</span>
                            @else
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded border border-red-200">Ditolak</span>
                            @endif
                        </td>

                        {{-- Kolom Aksi --}}
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center items-center space-x-2">

                                @if($bayar->status_pembayaran == 'verified')
                                <a href="{{ route('pendaftaran.cetak', $bayar->id) }}" target="_blank" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-xs px-2 py-1.5 transition" title="Cetak Kwitansi">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                    </svg>
                                </a>

                                {{-- PEMISAH VERTIKAL --}}
                                <div class="w-px h-6 bg-gray-300 mx-2"></div>
                                @endif
                                {{-- KONDISI 1: JIKA STATUS PENDING (Tampilkan Terima & Tolak) --}}
                                @if($bayar->status_pembayaran == 'pending')
                                {{-- Tombol Terima --}}
                                <form action="{{ route('admin.pembayaran.update_status', $bayar->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status_pembayaran" value="verified">
                                    <button type="button" class="btn-confirm-accept text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center shadow-sm" title="Terima Pembayaran">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                </form>

                                {{-- Tombol Tolak --}}
                                <form action="{{ route('admin.pembayaran.update_status', $bayar->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status_pembayaran" value="rejected">
                                    <button type="button" class="btn-confirm-reject text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center shadow-sm" title="Tolak Pembayaran">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </form>

                                {{-- KONDISI 2: JIKA SUDAH VERIFIED/LUNAS (Tampilkan Tombol Batalkan/Tolak) --}}
                                @elseif($bayar->status_pembayaran == 'verified')
                                <form action="{{ route('admin.pembayaran.update_status', $bayar->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    {{-- Ubah jadi rejected --}}
                                    <input type="hidden" name="status_pembayaran" value="rejected">
                                    <button type="button" class="btn-confirm-reject flex items-center text-xs text-red-600 hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg px-3 py-1.5 text-center transition">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Batalkan
                                    </button>
                                </form>

                                {{-- KONDISI 3: JIKA SUDAH DITOLAK (Tampilkan Tombol Terima Kembali) --}}
                                @else
                                <form action="{{ route('admin.pembayaran.update_status', $bayar->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    {{-- Ubah jadi verified --}}
                                    <input type="hidden" name="status_pembayaran" value="verified">
                                    <button type="button" class="btn-confirm-accept flex items-center text-xs text-green-600 hover:text-white border border-green-600 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg px-3 py-1.5 text-center transition">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        Tinjau Ulang
                                    </button>
                                </form>
                                @endif

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            Belum ada data pembayaran baru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $pembayarans->links() }}
        </div>
    </div>
</div>

{{-- MODAL GAMBAR (Menggunakan Alpine JS) --}}
<div x-data="{ open: false, imgSrc: '' }"
    @open-modal.window="open = true; imgSrc = $event.detail.img"
    @keydown.escape.window="open = false"
    class="relative z-50">

    {{-- Backdrop --}}
    <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black/80 backdrop-blur-sm"></div>

    {{-- Modal Content --}}
    <div x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 flex items-center justify-center p-4"
        @click.self="open = false">

        <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-hidden flex flex-col">
            <div class="p-4 border-b flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-gray-700">Bukti Pembayaran</h3>
                <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-4 overflow-auto bg-gray-900 flex justify-center">
                <img :src="imgSrc" class="max-w-full max-h-[70vh] object-contain rounded-md" alt="Bukti Transfer">
            </div>
            <div class="p-4 border-t bg-gray-50 text-right">
                <button @click="open = false" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 text-sm font-medium">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- Logic SweetAlert Konfirmasi --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {

        // Konfirmasi Terima
        const acceptBtns = document.querySelectorAll(".btn-confirm-accept");
        acceptBtns.forEach(btn => {
            btn.addEventListener("click", function(e) {
                const form = this.closest("form");
                Swal.fire({
                    title: 'Verifikasi Pembayaran?',
                    text: "Pembayaran akan ditandai LUNAS dan Mahasiswa dinyatakan Lulus.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10B981',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Verifikasi!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

        // Konfirmasi Tolak
        const rejectBtns = document.querySelectorAll(".btn-confirm-reject");
        rejectBtns.forEach(btn => {
            btn.addEventListener("click", function(e) {
                const form = this.closest("form");
                Swal.fire({
                    title: 'Tolak Pembayaran?',
                    text: "Mahasiswa harus mengupload ulang bukti pembayaran.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#EF4444',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Ya, Tolak!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    });
</script>

@endsection