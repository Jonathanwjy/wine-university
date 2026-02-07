@extends('admin.sidebar')

@section('content')

<div class="p-4">

    {{-- Pesan Sukses (Jika ada) --}}
    @if(session('success'))
    <div id="success-message-data" data-message="{{ session('success') }}" class="hidden"></div>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Data Pendaftar</h2>
            <p class="text-gray-500 text-sm mt-1">Daftar calon mahasiswa baru yang telah mengisi formulir.</p>
        </div>


    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-gray-200">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                <tr>
                    <th scope="col" class="px-6 py-3 w-10">No</th>
                    <th scope="col" class="px-6 py-3">Nama Lengkap</th>
                    <th scope="col" class="px-6 py-3">Program Studi</th>
                    <th scope="col" class="px-6 py-3">Asal Sekolah</th>
                    <th scope="col" class="px-6 py-3 text-center">Status</th>
                    <th scope="col" class="px-6 py-3 text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendaftarans as $key => $item)
                <tr class="bg-white border-b hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $pendaftarans->firstItem() + $key }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900">{{ $item->full_name }}</div>
                        <div class="text-xs text-gray-500">{{ $item->nomor_telepon }}</div>
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->prodi->nama_prodi ?? '-' }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->pendidikan_terakhir }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($item->status == 'accepted')
                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-400">Diterima</span>
                        @elseif($item->status == 'pending')
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded border border-yellow-400 animate-pulse">Pending</span>
                        @elseif($item->status == 'verified')
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded border border-blue-400">Terverifikasi</span>
                        @elseif($item->status == 'rejected')
                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded border border-red-400">Ditolak</span>
                        @else
                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded border border-gray-400">{{ ucfirst($item->status) }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        {{-- Tombol Detail --}}
                        <a href="{{ route('admin.detail_pendaftaran', $item->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 transition">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c5.477 0 9.268 2.943 10.542 7-1.274 4.057-5.065 7-10.542 7-5.477 0-9.268-2.943-10.542-7z"></path>
                            </svg>
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-gray-500 bg-white">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-base font-semibold">Belum ada pendaftar.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $pendaftarans->links() }}
    </div>

</div>

{{-- Script SweetAlert (Jika butuh notifikasi sukses) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const successMessageData = document.getElementById("success-message-data");
        if (successMessageData) {
            Swal.fire({
                title: "Berhasil!",
                text: successMessageData.dataset.message,
                icon: "success",
                timer: 3000,
                showConfirmButton: false
            });
        }
    });
</script>

@endsection