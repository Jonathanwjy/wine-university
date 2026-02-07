@extends('admin.sidebar')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="p-4">

    @if(session('success'))
    <div id="success-delete-message-data" data-message="{{ session('success') }}" class="hidden"></div>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Pengumuman</h2>
            <p class="text-gray-500 text-sm mt-1">Kelola semua informasi dan berita kampus di sini.</p>
        </div>
        <a href="{{ route('pengumuman.add') }}" class="mt-4 sm:mt-0 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center focus:outline-none transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Pengumuman
        </a>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-gray-200">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                <tr>
                    <th scope="col" class="px-6 py-3 w-10">No</th>
                    <th scope="col" class="px-6 py-3">Judul Pengumuman</th>
                    <th scope="col" class="px-6 py-3">Tagline</th>
                    <th scope="col" class="px-6 py-3">Tanggal Dibuat</th>
                    <th scope="col" class="px-6 py-3 text-center w-48">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengumumans as $key => $pengumuman)
                <tr class="bg-white border-b hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $pengumumans->firstItem() + $key }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-900 text-base">{{Str::limit($pengumuman->judul, 40) }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded border border-gray-300">
                            {{ Str::limit($pengumuman->tagline, 30) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $pengumuman->tanggal_dibuat }}
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('pengumuman.show', $pengumuman->id) }}" class="p-2 text-blue-600 bg-blue-100 rounded-lg hover:bg-blue-200 focus:ring-2 focus:ring-blue-400 transition" title="Lihat Detail">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c5.477 0 9.268 2.943 10.542 7-1.274 4.057-5.065 7-10.542 7-5.477 0-9.268-2.943-10.542-7z"></path>
                                </svg>
                            </a>

                            <a href="{{ route('pengumuman.edit', $pengumuman->id) }}" class="p-2 text-yellow-600 bg-yellow-100 rounded-lg hover:bg-yellow-200 focus:ring-2 focus:ring-yellow-400 transition" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>

                            <a href="{{ route('pengumuman.delete', $pengumuman->id) }}" class="p-2 text-red-600 bg-red-100 rounded-lg hover:bg-red-200 focus:ring-2 focus:ring-red-400 transition pengumuman-delete" title="Hapus">
                                <svg class=" w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 bg-white">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-base font-semibold">Belum ada pengumuman.</p>
                            <p class="text-sm">Silakan buat pengumuman baru.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $pengumumans->links() }}
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        // --- 1. LOGIKA KONFIRMASI DELETE ---
        const deleteButtons = document.querySelectorAll(".pengumuman-delete");

        deleteButtons.forEach((item) => {
            item.addEventListener("click", function(e) {
                e.preventDefault(); // Mencegah pindah halaman langsung

                // Cek apakah Swal sudah dimuat
                if (typeof Swal === 'undefined') {
                    alert('Library SweetAlert belum dimuat!');
                    return;
                }

                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Data pengumuman ini akan dihapus secara permanen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal",
                    reverseButtons: true,
                    // Styling tombol agar sesuai tema Tailwind
                    customClass: {
                        confirmButton: "bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg mr-2 border-0",
                        cancelButton: "bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg mr-2 border-0",
                        popup: 'rounded-xl'
                    },
                    buttonsStyling: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect ke link href
                        window.location.href = item.href;
                    }
                });
            });
        });

        // --- 2. LOGIKA ALERT SUKSES (SETELAH DELETE) ---
        // Mencari elemen div yang kita buat di atas tadi
        const successMessageElement = document.getElementById("success-delete-message-data");

        if (successMessageElement) {
            const message = successMessageElement.dataset.message;

            Swal.fire({
                title: "Berhasil!",
                text: message,
                icon: "success",
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg border-0",
                },
                buttonsStyling: false,
            });
            // Hapus elemen penanda agar tidak muncul lagi jika direfresh (opsional)
            successMessageElement.remove();
        }
    });
</script>

@endsection