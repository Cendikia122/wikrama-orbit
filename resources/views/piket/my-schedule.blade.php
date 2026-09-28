@extends('layouts.app')
@section('title', 'Jadwal Piket GDS Saya')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- ── Breadcrumb ── --}}
    <div class="flex items-center gap-2 text-xs text-slate-400 mb-6">
        <a href="/piket" class="hover:text-slate-600 transition-colors">Jadwal Piket GDS</a>
        <span>&rsaquo;</span>
        <span class="text-slate-600 font-medium">Jadwal Piketku</span>
    </div>

    {{-- ── Header ── --}}
    <div class="mb-8">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background:#1E3A8A;">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Jadwal Piket GDS: {{ Auth::user()->name }}</h1>
                <p class="text-sm text-slate-500 mt-0.5">Penugasan Gerakan Disiplin Siswa (GDS) pagi di gerbang masuk SMKS Wikrama Bogor.</p>
            </div>
        </div>
    </div>

    @php
        $nextPiket = $piket->first();
        $isToday = $nextPiket && \Carbon\Carbon::parse($nextPiket->tanggal)->isToday();
        $isTomorrow = $nextPiket && \Carbon\Carbon::parse($nextPiket->tanggal)->isTomorrow();
    @endphp

    {{-- ── PROMINENT BOLD CARD: KAPAN GDS ── --}}
    <div class="mb-8">
        @if($nextPiket)
            <div class="bg-gradient-to-r from-navy to-navy-dark text-white rounded-2xl p-6 md:p-8 shadow-lg relative overflow-hidden" style="background: linear-gradient(135deg, #0F172A 0%, #1E3A8A 100%);">
                <div class="flex items-start justify-between gap-4 flex-wrap">
                    <div>
                        <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold mb-3">
                            <span class="w-2 h-2 rounded-full {{ $isToday ? 'bg-red-400 animate-pulse' : 'bg-emerald-400' }}"></span>
                            {{ $isToday ? 'Piket Hari Ini!' : ($isTomorrow ? 'Piket Besok Pagi!' : 'Jadwal Piket Terdekat') }}
                        </div>
                        <h2 class="text-xs uppercase tracking-widest text-blue-200 font-semibold mb-1">
                            Kapan Sih Anda Bertugas GDS?
                        </h2>
                        <p class="text-3xl md:text-4xl font-extrabold text-white tracking-tight mt-1">
                            {{ \Carbon\Carbon::parse($nextPiket->tanggal)->isoFormat('dddd, D MMMM Y') }}
                        </p>
                        <p class="text-base font-semibold text-blue-200 mt-2 flex items-center gap-2">
                            <span>🕒 Jam: 05.50 – 07.15 WIB (Shift {{ $nextPiket->shift }})</span>
                            <span class="text-white/40">|</span>
                            <span>📍 Pos: Gerbang Masuk Utama</span>
                        </p>
                    </div>

                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl px-5 py-4 text-center shrink-0">
                        <p class="text-xs text-blue-200 uppercase font-bold">Status Tugas</p>
                        <p class="text-2xl font-black text-white mt-1">
                            @if($isToday)
                                HARI INI
                            @elseif($isTomorrow)
                                BESOK
                            @else
                                {{ \Carbon\Carbon::parse($nextPiket->tanggal)->diffForHumans() }}
                            @endif
                        </p>
                    </div>
                </div>

                <div class="mt-6 pt-5 border-t border-white/10 flex items-center gap-2 text-xs text-blue-200">
                    <svg class="w-4 h-4 shrink-0 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Harap hadir di pos sebelum pukul 05.45 WIB dengan seragam rapi dan atribut lengkap.</span>
                </div>
            </div>
        @else
            <div class="bg-white border border-slate-200 rounded-2xl p-6 text-center shadow-sm">
                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-3 text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-800">Tidak Ada Piket Mendatang</h3>
                <p class="text-sm text-slate-500 mt-1">Nama Anda belum terdaftar dalam penugasan piket GDS berikutnya.</p>
                <a href="/piket" class="btn-primary mt-4 inline-flex text-xs px-4 py-2">Lihat Seluruh Jadwal Piket</a>
            </div>
        @endif
    </div>

    {{-- ── FULL SCHEDULE LIST ── --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900">Daftar Lengkap Jadwal Anda</h2>
                <p class="text-xs text-slate-500">Semua giliran piket GDS yang tercatat atas nama {{ Auth::user()->name }}.</p>
            </div>
            <span class="badge bg-slate-100 text-slate-600 font-bold text-xs">{{ $piket->count() }} Jadwal</span>
        </div>

        @if($piket->count() > 0)
            <div class="divide-y divide-slate-100">
                @foreach($piket as $p)
                    @php
                        $tgl = \Carbon\Carbon::parse($p->tanggal);
                        $isIni = $tgl->isToday();
                    @endphp
                    <div class="p-5 flex items-center justify-between gap-4 {{ $isIni ? 'bg-amber-50/50' : 'hover:bg-slate-50' }} transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl {{ $isIni ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700' }} flex flex-col items-center justify-center text-center shrink-0">
                                <span class="text-xs font-semibold uppercase leading-none">{{ $tgl->format('M') }}</span>
                                <span class="text-base font-extrabold leading-none mt-0.5">{{ $tgl->format('d') }}</span>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-sm font-bold text-slate-900 {{ $isIni ? 'text-amber-900' : '' }}">
                                        {{ $tgl->isoFormat('dddd, D MMMM Y') }}
                                    </h3>
                                    @if($isIni)
                                        <span class="badge bg-red-100 text-red-700 font-bold text-xs">Hari Ini!</span>
                                    @endif
                                </div>
                                <p class="text-xs text-slate-500 mt-1 flex items-center gap-3">
                                    <span>🕒 Shift {{ $p->shift }} (05.50 - 07.15 WIB)</span>
                                    <span>•</span>
                                    <span>Jabatan: {{ $p->jabatan_petugas ?? 'Petugas GDS' }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="text-right shrink-0">
                            <span class="badge {{ $isIni ? 'bg-amber-200 text-amber-900' : 'bg-slate-100 text-slate-600' }} text-xs">
                                {{ $tgl->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 text-center text-slate-400 text-sm">
                Tidak ada riwayat jadwal piket lainnya.
            </div>
        @endif
    </div>

</div>
@endsection
