@extends('template.navbar')

@section('content')

<div class="mb-6">

</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

    <div class="p-6 sm:p-10 border-b border-gray-100 bg-gray-50/50">

        <div class="flex items-center gap-3 mb-4">
            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-blue-400">
                Pengumuman
            </span>
            <span class="text-sm text-gray-500 flex items-center">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{ $pengumuman->tanggal_dibuat }}
            </span>
        </div>

        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-3 leading-tight tracking-tight">
            {{ $pengumuman->judul }}
        </h1>

        @if(!empty($pengumuman->tagline))
        <div class="mt-4 pl-4 border-l-4 border-blue-500">
            <p class="text-xl text-gray-600 font-medium italic">
                "{{ $pengumuman->tagline }}"
            </p>
        </div>
        @endif
    </div>

    <div class="p-6 sm:p-10">
        <div class="text-gray-800 leading-relaxed text-lg whitespace-pre-line text-justify">
            {!! nl2br(e($pengumuman->isi)) !!}
        </div>
    </div>

    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
        <span class="text-xs text-gray-400">
            Dibuat pada: {{ $pengumuman->created_at->format('d M Y H:i') }}
        </span>


    </div>

</div>

@endsection