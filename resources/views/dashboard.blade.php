@extends('template.navbar')
@section('content')

<div class="relative h-[60vh] bg-gray-900 flex items-center justify-center overflow-hidden">

    <div
        class="absolute inset-0 bg-cover bg-center filter brightness-50"
        style="background-image: url('{{ asset('images/kampus.jpg') }}')"
        aria-hidden="true"></div>

    <div class="relative z-10 text-center px-4">

        <h1 class="text-4xl sm:text-6xl font-extrabold text-white mb-6 tracking-tight">
            Selamat Datang di <span class="text-blue-400">WISE UNIVERSITY</span>
        </h1>

        <p class="text-lg sm:text-xl text-gray-200 mb-10 max-w-2xl mx-auto">
            Wujudkan masa depan Anda bersama kami. Raih pengetahuan, inovasi, dan kebebasan.
        </p>

        <a
            href="{{ route('pendaftaran') }}"
            class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-semibold rounded-lg shadow-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50 transition duration-300 transform hover:scale-105">
            Daftar Sekarang
            <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
            </svg>
        </a>
    </div>
</div>

<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

    <h2 class="text-3xl font-extrabold text-gray-900 border-b pb-2 mb-8">
        <span class="text-blue-600">
            <i class="fas fa-bullhorn mr-2"></i>
        </span>
        Pengumuman Terbaru
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        @forelse ($pengumumans as $pengumuman)

        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 transform hover:translate-y-[-2px] border-l-4 border-blue-600 flex flex-col justify-between min-h-[250px]">

            <div>
                <div class="flex items-start justify-between mb-3">
                    <h3 class="text-xl font-bold text-gray-800 flex items-start">
                        <svg class="w-6 h-6 text-blue-600 mr-2 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        {{ $pengumuman->judul }}
                    </h3>

                    <p class="text-xs text-gray-500 ml-4 flex-shrink-0">
                        <i class="far fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($pengumuman->tanggal_dibuat)->locale('id')->diffForHumans() }}
                    </p>
                </div>

                <p class="text-sm font-medium text-blue-500 mb-3 border-b pb-2">
                    {{ $pengumuman->tagline }}
                </p>

                <p class="mt-3 text-gray-700 leading-relaxed text-sm">
                    {{ Str::limit($pengumuman->isi, 200, '...') }}
                </p>
            </div>

            <div class="mt-4 pt-4 border-t border-gray-100">
                <a href="{{ url('/detail_pengumuman/' . $pengumuman->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">Baca Selengkapnya &rarr;</a>
            </div>

        </div>
        @empty

        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-gray-300 col-span-full">
            <p class="text-gray-500 text-center">
                <i class="fas fa-exclamation-circle mr-2"></i> Saat ini belum ada pengumuman terbaru.
            </p>
        </div>
        @endforelse

    </div>

</section>


<div id="about" class="py-16 sm:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid md:grid-cols-2 gap-12 items-center">

            <div class="space-y-6">
                <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                    Tentang Kami
                </p>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 leading-tight">
                    Menciptakan Masa Depan Melalui Pengetahuan dan Inovasi
                </h2>

                <p class="mt-4 text-lg text-gray-600">
                    WISE University didirikan dengan visi untuk menjadi pusat keunggulan akademik yang menghasilkan lulusan yang tidak hanya kompeten secara profesional tetapi juga memiliki integritas dan pemikiran kritis. Kami percaya bahwa pendidikan adalah kunci untuk membuka potensi penuh individu.
                </p>
                <p class="mt-4 text-gray-600">
                    Fokus kami adalah pada **Knowledge, Innovation, and Freedom**. Kami menyediakan lingkungan belajar yang kolaboratif, didukung oleh fasilitas modern dan tenaga pengajar yang berdedikasi, untuk mendorong mahasiswa menjadi pemimpin masa depan yang mampu menghadapi tantangan global.
                </p>

            </div>

            <div class="order-first md:order-none">
                <img
                    class="rounded-xl shadow-2xl object-cover w-full h-auto"
                    src="{{ asset('images/main_logo.jpg') }}"
                    alt="Gambar Kampus atau Logo WISE University">
            </div>
        </div>
    </div>
</div>

<div id="prodi" class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

    <div class="border-t border-gray-200 my-10"></div>

    <div id="prodi">
        <h2 class="text-3xl font-extrabold text-gray-900 border-b pb-2 mb-8">
            <span class="text-blue-600">
                <i class="fas fa-graduation-cap mr-2"></i>
            </span>
            Program Studi Unggulan
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @forelse ($prodis as $prodi)
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-[1.02] border-t-4 border-blue-500 flex flex-col items-center text-center">

                <div class="p-3 mb-4 rounded-full bg-blue-50 text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                </div>

                <h3 class="text-xl font-bold text-gray-900 mb-2">
                    {{ $prodi->nama_prodi }}
                </h3>

                <p class="text-gray-600 text-sm mb-4">
                    Fokus pada pengembangan keterampilan praktis dan teoritis di bidang {{ strtolower($prodi->nama_prodi) }}.
                </p>


            </div>
            @empty
            <div class="col-span-full text-center p-8 bg-white rounded-lg shadow-md">
                <p class="text-gray-500">Data program studi belum tersedia.</p>
            </div>
            @endforelse

        </div>
    </div>
</div>

<div id="visi-misi" class="py-16 sm:py-24 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900">
                Visi dan Misi
            </h1>
            <p class="mt-3 text-xl text-gray-600">
                Landasan dan tujuan utama WISE University.
            </p>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-lg mb-10 border-l-4 border-blue-600">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM12 4.5v15M4.5 12h15"></path>
                </svg>
                Visi
            </h2>
            <blockquote class="text-xl italic text-gray-700">
                "Menjadi Universitas terdepan di Asia Tenggara yang unggul dalam menghasilkan lulusan berintegritas tinggi, inovatif, dan berwawasan global pada tahun 2035."
            </blockquote>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-lg border-l-4 border-green-600">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13l3 3l7-7m-9 5l7-7l3-3"></path>
                </svg>
                Misi
            </h2>
            <ul class="space-y-4 text-gray-700 text-lg">
                <li class="flex items-start">
                    <span class="text-green-600 font-bold mr-3">•</span>
                    Menyelenggarakan proses pembelajaran yang relevan dengan perkembangan industri 4.0, fokus pada aplikasi praktis.
                </li>
                <li class="flex items-start">
                    <span class="text-green-600 font-bold mr-3">•</span>
                    Meningkatkan kualitas penelitian dan publikasi ilmiah yang berdampak positif pada masyarakat.
                </li>
                <li class="flex items-start">
                    <span class="text-green-600 font-bold mr-3">•</span>
                    Melaksanakan kegiatan pengabdian masyarakat yang berbasis inovasi dan teknologi.
                </li>
                <li class="flex items-start">
                    <span class="text-green-600 font-bold mr-3">•</span>
                    Membangun kemitraan strategis dengan institusi domestik dan internasional.
                </li>
            </ul>
        </div>

    </div>
</div>

@endsection