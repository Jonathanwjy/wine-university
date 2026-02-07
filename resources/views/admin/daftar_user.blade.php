@extends('admin.sidebar')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="p-4">

    {{-- Menangkap pesan sukses dari Controller --}}
    @if(session('success'))
    <div id="success-message-data" data-message="{{ session('success') }}" class="hidden"></div>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Verifikasi Pengguna</h2>
            <p class="text-gray-500 text-sm mt-1">Setujui atau tolak pendaftaran akun pengguna.</p>
        </div>


    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-gray-200">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                <tr>
                    <th scope="col" class="px-6 py-3 w-10">No</th>
                    <th scope="col" class="px-6 py-3">Nama & Email</th>
                    <th scope="col" class="px-6 py-3">Role</th>
                    <th scope="col" class="px-6 py-3 text-center">Status Saat Ini</th>
                    <th scope="col" class="px-6 py-3">Tanggal Daftar</th>
                    <th scope="col" class="px-6 py-3 text-center w-48">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $key => $user)
                <tr class="bg-white border-b hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $users->firstItem() + $key }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900">{{ $user->full_name ?? 'User' }}</div>
                        <div class="text-xs text-gray-500">{{ $user->email }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded border border-gray-300 uppercase">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($user->status == 'active')
                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-400">
                            Active
                        </span>
                        @elseif($user->status == 'pending')
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded border border-yellow-400 animate-pulse">
                            Pending
                        </span>
                        @else
                        {{-- Menangkap status inactive/rejected --}}
                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded border border-red-400">
                            Inactive
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center text-xs text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $user->created_at->format('d M Y') }}
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center space-x-2">

                            {{-- KONDISI 1: JIKA STATUS SUDAH ACTIVE (Hanya muncul tombol Nonaktifkan) --}}
                            @if($user->status == 'active')

                            <form action="{{ route('admin.users.update_status', $user->id) }}" method="POST" class="form-status-change">
                                @csrf
                                @method('PATCH')
                                {{-- PERBAIKAN: Value harus inactive, bukan rejected (sesuai controller) --}}
                                <input type="hidden" name="status" value="inactive">
                                <button type="button" class="btn-deactivate p-2 px-4 text-white bg-orange-500 rounded-lg hover:bg-orange-600 focus:ring-2 focus:ring-orange-400 transition shadow-sm w-full flex justify-center items-center gap-1" title="Nonaktifkan User">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                    </svg>
                                    <span class="text-xs font-bold">Nonaktifkan</span>
                                </button>
                            </form>

                            {{-- KONDISI 2: JIKA STATUS PENDING ATAU INACTIVE (Muncul Terima & Tolak) --}}
                            @else

                            {{-- Tombol Terima --}}
                            <form action="{{ route('admin.users.update_status', $user->id) }}" method="POST" class="form-status-change">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="active">
                                <button type="button" class="btn-approve p-2 text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-400 transition shadow-sm flex justify-center items-center gap-1" title="Setujui">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-xs font-bold">Terima</span>
                                </button>
                            </form>

                            {{-- Tombol Tolak (Hanya muncul jika belum inactive agar tidak duplikat) --}}
                            @if($user->status !== 'inactive')
                            <form action="{{ route('admin.users.update_status', $user->id) }}" method="POST" class="form-status-change">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="inactive">
                                <button type="button" class="btn-reject p-2 text-white bg-red-500 rounded-lg hover:bg-red-600 focus:ring-2 focus:ring-red-400 transition shadow-sm flex justify-center items-center gap-1" title="Tolak">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span class="text-xs font-bold">Tolak</span>
                                </button>
                            </form>
                            @endif

                            @endif

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-gray-500 bg-white">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <p class="text-base font-semibold">Tidak ada data pengguna.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        // --- Alert Sukses ---
        const successMessageData = document.getElementById("success-message-data");
        if (successMessageData) {
            Swal.fire({
                title: "Berhasil!",
                text: successMessageData.dataset.message,
                icon: "success",
                timer: 2000,
                showConfirmButton: false
            });
        }

        // --- LOGIKA 1: Tombol Terima (Approve) ---
        const approveButtons = document.querySelectorAll(".btn-approve");
        approveButtons.forEach((btn) => {
            btn.addEventListener("click", function(e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: "Terima Pengguna?",
                    text: "User akan menjadi status Active dan dapat login.",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Ya, Terima",
                    cancelButtonText: "Batal",
                    confirmButtonColor: "#10B981", // Hijau
                    cancelButtonColor: "#6B7280",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

        // --- LOGIKA 2: Tombol Tolak (Reject) ---
        const rejectButtons = document.querySelectorAll(".btn-reject");
        rejectButtons.forEach((btn) => {
            btn.addEventListener("click", function(e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: "Tolak Pendaftaran?",
                    text: "User tidak akan bisa mengakses sistem.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, Tolak",
                    cancelButtonText: "Batal",
                    confirmButtonColor: "#EF4444", // Merah
                    cancelButtonColor: "#6B7280",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

        // --- LOGIKA 3: Tombol Nonaktifkan (Deactivate) ---
        const deactivateButtons = document.querySelectorAll(".btn-deactivate");
        deactivateButtons.forEach((btn) => {
            btn.addEventListener("click", function(e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: "Nonaktifkan Akun?",
                    text: "User yang aktif akan kehilangan akses login.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, Nonaktifkan",
                    cancelButtonText: "Batal",
                    confirmButtonColor: "#F97316", // Orange
                    cancelButtonColor: "#6B7280",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

    });
</script>

@endsection