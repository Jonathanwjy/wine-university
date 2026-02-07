@extends('admin.sidebar')

@section('content')
<div class="min-h-screen flex justify-center items-start pt-10 px-4 font-sans text-gray-900">

    <div class="w-full max-w-3xl bg-white flex flex-col rounded-xl p-8 sm:p-10 shadow-xl border border-gray-200">

        <div class="mb-8 border-b border-gray-100 pb-4">
            <h1 class="font-extrabold text-2xl sm:text-3xl text-gray-800 mb-2">Buat Pengumuman Baru</h1>
            <p class="text-gray-500 text-sm">
                Isi formulir di bawah ini untuk mempublikasikan informasi terbaru.
            </p>
        </div>

        <form action="{{ route('pengumuman.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="md:col-span-2 space-y-2">
                    <label for="judul" class="block text-sm font-medium text-gray-700">Judul Pengumuman</label>
                    <input type="text" id="judul" name="judul"
                        placeholder="Contoh: Jadwal Libur Semester Genap"
                        value="{{ old('judul') }}"
                        class="w-full h-11 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-sm" />
                    @error('judul') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2 space-y-2">
                    <label for="tagline" class="block text-sm font-medium text-gray-700">Tagline / Sub-Judul</label>
                    <input type="text" id="tagline" name="tagline"
                        placeholder="Singkat, padat, dan menarik (Opsional)"
                        value="{{ old('tagline') }}"
                        class="w-full h-11 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-sm" />
                    @error('tagline') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="tanggal_dibuat" class="block text-sm font-medium text-gray-700">Tanggal Publikasi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input type="date" id="tanggal_dibuat" name="tanggal_dibuat"
                            value="{{ old('tanggal_dibuat', date('Y-m-d')) }}"
                            class="w-full h-11 pl-10 pr-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-sm" />
                    </div>
                    @error('tanggal_dibuat') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="hidden md:block"></div>

                <div class="md:col-span-2 space-y-2">
                    <label for="isi" class="block text-sm font-medium text-gray-700">Isi Pengumuman</label>
                    <textarea id="isi" name="isi" rows="8"
                        placeholder="Tuliskan detail pengumuman di sini..."
                        class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-sm leading-relaxed">{{ old('isi') }}</textarea>
                    <p class="text-xs text-gray-500 text-right">Tekan Enter untuk membuat paragraf baru.</p>
                    @error('isi') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

            </div>

            <div class="pt-6 border-t border-gray-100 flex items-center justify-end space-x-4">

                <button type="submit"
                    class="px-5 py-2.5 text-sm font-medium text-white bg-gray-800 rounded-lg hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-500 transition flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    Simpan Pengumuman
                </button>
            </div>

        </form>
    </div>
</div>
@endsection