@extends('template.navbar')

@section('content')

<div class="min-h-screen flex justify-center items-center from-indigo-50 to-blue-100 px-4 py-8 font-sans">
    <div class="w-full max-w-3xl bg-white flex flex-col rounded-xl p-8 sm:p-10 shadow-xl border border-gray-200">


        <div class="text-center mb-8">
            <h1 class="font-extrabold text-2xl sm:text-3xl text-gray-800 mb-2">Universitas Wise</h1>
            <h3 class="font-bold text-md sm:text-xl text-gray-600 mb-2">Formulir Pendaftaran Mahasiswa Baru</h3>
            <p class="text-gray-500 text-sm">Lengkapi data diri Anda dengan benar</p>
        </div>
        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm relative" role="alert">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div>
                    <p class="font-bold">Pendaftaran Gagal</p>
                    <p class="text-sm">{{ session('error') }}</p> {{-- Ini akan mencetak: "Anda sudah terdaftar..." --}}
                </div>
            </div>
        </div>
        @endif
        <form action="{{ route('pendaftaran.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="md:col-span-2 space-y-2">
                    <label for="full_name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" id="full_name" name="full_name" placeholder="Sesuai KTP/Ijazah" value="{{ old('full_name') }}"
                        class="w-full h-11 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-sm" />
                    @error('full_name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="tempat_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" placeholder="Kota Kelahiran" value="{{ old('tempat_lahir') }}"
                        class="w-full h-11 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-sm" />
                    @error('tempat_lahir') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                        class="w-full h-11 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-sm" />
                    @error('tanggal_lahir') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="w-full h-11 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-sm bg-white">
                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="nomor_telepon" class="block text-sm font-medium text-gray-700">Nomor Telepon / WA</label>
                    <input type="number" id="nomor_telepon" name="nomor_telepon" placeholder="08xxxxxxxxxx" value="{{ old('nomor_telepon') }}"
                        class="w-full h-11 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-sm" />
                    @error('nomor_telepon') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="pendidikan_terakhir" class="block text-sm font-medium text-gray-700">Pendidikan Terakhir</label>
                    <select id="pendidikan_terakhir" name="pendidikan_terakhir" class="w-full h-11 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-sm bg-white">
                        <option value="" disabled selected>Pilih Pendidikan</option>
                        <option value="SMA" {{ old('pendidikan_terakhir') == 'SMA' ? 'selected' : '' }}>SMA / SMK / MA</option>
                        <option value="D3" {{ old('pendidikan_terakhir') == 'D3' ? 'selected' : '' }}>D3</option>
                        <option value="S1" {{ old('pendidikan_terakhir') == 'S1' ? 'selected' : '' }}>S1</option>
                    </select>
                    @error('pendidikan_terakhir') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="prodi_id" class="block text-sm font-medium text-gray-700">Pilihan Program Studi</label>
                    <select id="prodi_id" name="prodi_id" class="w-full h-11 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-sm bg-white">
                        <option value="" disabled selected>Pilih Prodi Tujuan</option>
                        {{-- Loop Data Prodi dari Controller --}}
                        @foreach($prodis as $prodi)
                        <option value="{{ $prodi->id }}" {{ old('prodi_id') == $prodi->id ? 'selected' : '' }}>
                            {{ $prodi->nama_prodi ?? 'Nama Prodi' }}
                        </option>
                        @endforeach
                    </select>
                    @error('prodi_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2 space-y-2">
                    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                    <textarea id="alamat" name="alamat" rows="3" placeholder="Nama Jalan, RT/RW, Kelurahan, Kecamatan"
                        class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-sm">{{ old('alamat') }}</textarea>
                    @error('alamat') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full py-3 px-4 bg-gray-600 text-white rounded-lg font-semibold hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-300 ease-in-out transform hover:scale-[1.01] active:scale-[0.98] text-base sm:text-lg flex justify-center items-center shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Kirim Pendaftaran
                </button>
            </div>

        </form>

    </div>
</div>


@endsection