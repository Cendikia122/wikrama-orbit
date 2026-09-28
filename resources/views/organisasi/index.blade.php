@extends('layouts.app')
@section('title', 'Struktur Organisasi OSIS-MPR')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- ── Page Header ── --}}
    <div class="text-center mb-12">
        <span class="badge bg-navy/10 text-navy mb-3">SMKS Wikrama Bogor</span>
        <h1 class="text-3xl font-extrabold text-slate-900">Struktur Organisasi OSIS-MPR</h1>
        <p class="text-sm text-slate-500 mt-2 max-w-xl mx-auto">
            Susunan kepengurusan OSIS dan MPR masa bakti aktif serta arsip kepengurusan terdahulu SMKS Wikrama Bogor.
        </p>
    </div>

    {{-- ────────────────────────────────────────────── --}}
    {{-- 1. PEMBINA OSIS --}}
    {{-- ────────────────────────────────────────────── --}}
    @if(isset($pembina) && $pembina->count() > 0)
        <div class="mb-14">
            <div class="flex items-center gap-3 mb-6">
                <div class="h-px flex-1 bg-slate-200"></div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pembina OSIS</span>
                <div class="h-px flex-1 bg-slate-200"></div>
            </div>
            <div class="flex justify-center flex-wrap gap-4">
                @foreach($pembina as $pem)
                    <div class="bg-gradient-to-br from-slate-900 to-navy text-white rounded-2xl px-8 py-6 flex items-center gap-5 max-w-md w-full shadow-lg" style="background:linear-gradient(135deg,#0F172A 0%,#1E3A8A 100%);">
                        <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center text-2xl font-black shrink-0 border border-white/30">
                            {{ strtoupper(substr($pem->name, 0, 1)) }}
                        </div>
                        <div>
                            <span class="badge bg-white/20 text-blue-200 text-xs font-semibold mb-1">Pembina Utama</span>
                            <p class="font-bold text-lg text-white leading-snug">{{ $pem->name }}</p>
                            <p class="text-xs text-blue-200 mt-0.5">{{ $pem->jabatan ?? 'Pembina OSIS Wikrama' }}</p>
                            @if($pem->angkatan)
                                <p class="text-xs text-white/60 mt-1">Periode: {{ $pem->angkatan }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ────────────────────────────────────────────── --}}
    {{-- 2. DEWAN PENASIHAT --}}
    {{-- ────────────────────────────────────────────── --}}
    @if(isset($dewan_penasihat) && $dewan_penasihat->count() > 0)
        <div class="mb-14">
            <div class="flex items-center gap-3 mb-6">
                <div class="h-px flex-1 bg-slate-200"></div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Dewan Penasihat</span>
                <div class="h-px flex-1 bg-slate-200"></div>
            </div>
            <div class="flex flex-wrap justify-center gap-4">
                @foreach($dewan_penasihat as $dp)
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 text-center shadow-sm w-48 shrink-0 hover:shadow-md transition-shadow">
                        <div class="w-14 h-14 rounded-full bg-purple-100 text-purple-800 font-bold text-xl flex items-center justify-center mx-auto mb-3">
                            {{ strtoupper(substr($dp->name, 0, 1)) }}
                        </div>
                        <p class="text-sm font-bold text-slate-900 leading-snug">{{ $dp->name }}</p>
                        <p class="text-xs text-slate-500 mt-1">{{ $dp->jabatan ?? 'Dewan Penasihat' }}</p>
                        @if($dp->angkatan)
                            <span class="badge bg-purple-50 text-purple-700 border border-purple-200 mt-2 text-xs">Angk. {{ $dp->angkatan }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ────────────────────────────────────────────── --}}
    {{-- 3. MAJELIS PERWAKILAN RAKYAT (MPR) --}}
    {{-- ────────────────────────────────────────────── --}}
    @if(isset($mpr) && $mpr->count() > 0)
        <div class="mb-14">
            <div class="flex items-center gap-3 mb-6">
                <div class="h-px flex-1 bg-slate-200"></div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">MPR (Majelis Perwakilan Rakyat)</span>
                <div class="h-px flex-1 bg-slate-200"></div>
            </div>
            <div class="flex flex-wrap justify-center gap-4">
                @foreach($mpr as $m)
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 text-center shadow-sm w-48 shrink-0 hover:shadow-md transition-shadow">
                        <div class="w-14 h-14 rounded-full bg-amber-100 text-amber-800 font-bold text-xl flex items-center justify-center mx-auto mb-3">
                            {{ strtoupper(substr($m->name, 0, 1)) }}
                        </div>
                        <p class="text-sm font-bold text-slate-900 leading-snug">{{ $m->name }}</p>
                        <p class="text-xs text-slate-500 mt-1">{{ $m->jabatan ?? 'Pengurus MPR' }}</p>
                        @if($m->angkatan)
                            <span class="badge bg-amber-50 text-amber-700 border border-amber-200 mt-2 text-xs">Angk. {{ $m->angkatan }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ────────────────────────────────────────────── --}}
    {{-- 4. DEWAN HARIAN (DH) --}}
    {{-- ────────────────────────────────────────────── --}}
    @if(isset($dewan_harian) && $dewan_harian->count() > 0)
        <div class="mb-14">
            <div class="flex items-center gap-3 mb-6">
                <div class="h-px flex-1 bg-slate-200"></div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Dewan Harian (DH)</span>
                <div class="h-px flex-1 bg-slate-200"></div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($dewan_harian as $dh)
                    @php
                        $jc = match($dh->jabatan) {
                            'Ketua Umum'      => 'bg-navy/10 text-navy border-navy/20',
                            'Ketua 1', 'Ketua 2' => 'bg-blue-50 text-blue-700 border-blue-200',
                            'Sekretaris Umum', 'Sekretaris 1', 'Sekretaris 2' => 'bg-purple-50 text-purple-700 border-purple-200',
                            'Bendahara Umum', 'Bendahara 1', 'Bendahara 2' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            default           => 'bg-slate-100 text-slate-600 border-slate-200',
                        };
                    @endphp
                    <div class="bg-white border border-slate-200 rounded-2xl p-4 text-center shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-800 font-bold text-lg flex items-center justify-center mx-auto mb-2.5">
                            {{ strtoupper(substr($dh->name, 0, 1)) }}
                        </div>
                        <p class="text-xs font-bold text-slate-900 leading-snug line-clamp-1">{{ $dh->name }}</p>
                        <span class="badge {{ $jc }} border mt-1.5 text-xs font-semibold block truncate">
                            {{ $dh->jabatan ?? 'Dewan Harian' }}
                        </span>
                        @if($dh->angkatan)
                            <p class="text-[11px] text-slate-400 mt-1">Angk. {{ $dh->angkatan }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ────────────────────────────────────────────── --}}
    {{-- 5. SEKSI BIDANG 1 - 10 --}}
    {{-- ────────────────────────────────────────────── --}}
    @php
        $sekbidInfo = [
            1  => ['nama' => 'Keimanan & Ketakwaan',       'emoji' => '🕌', 'color' => 'green',   'tugas' => 'Peribadatan, toleransi beragama, dan kegiatan amaliyah.'],
            2  => ['nama' => 'Budi Pekerti Luhur',         'emoji' => '✨', 'color' => 'yellow',  'tugas' => 'Penegakan tata tertib, sopan santun, dan program GDS.'],
            3  => ['nama' => 'Kepribadian & Bela Negara',  'emoji' => '🇮🇩', 'color' => 'red',     'tugas' => 'Upacara bendera, Paskibra, dan wawasan kebangsaan.'],
            4  => ['nama' => 'Prestasi & Bimbingan Minat', 'emoji' => '🏆', 'color' => 'purple',  'tugas' => 'Delegasi lomba akademik/non-akademik dan mentorship prestasi.'],
            5  => ['nama' => 'Demokrasi & Lingkungan Hidup','emoji' => '🌿', 'color' => 'emerald', 'tugas' => 'Pemilu OSIS, zero waste, penegakan misting/tumbler.'],
            6  => ['nama' => 'Kreativitas & Kewirausahaan','emoji' => '💡', 'color' => 'orange',  'tugas' => 'Bazar siswa, ekonomi kreatif, dan produk vokasi.'],
            7  => ['nama' => 'Kualitas Jasmani & Gizi',    'emoji' => '🥗', 'color' => 'teal',    'tugas' => 'Senam pagi, sarapan sehat, dan pemantauan kantin bersih.'],
            8  => ['nama' => 'Sastra & Seni Budaya',       'emoji' => '🎭', 'color' => 'pink',    'tugas' => 'Pentas seni, literasi sekolah, dan apresiasi budaya daerah.'],
            9  => ['nama' => 'Teknologi Informasi & Kom.', 'emoji' => '💻', 'color' => 'blue',    'tugas' => 'Pengelolaan platform digital, media sosial, & cyber literacy.'],
            10 => ['nama' => 'Komunikasi Bahasa Inggris',  'emoji' => '🌐', 'color' => 'indigo',  'tugas' => 'English day, speaking club, & kompetisi debat bahasa inggris.'],
        ];
    @endphp

    <div class="mb-14">
        <div class="flex items-center gap-3 mb-6">
            <div class="h-px flex-1 bg-slate-200"></div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">10 Seksi Bidang OSIS</span>
            <div class="h-px flex-1 bg-slate-200"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @foreach($sekbidInfo as $num => $info)
                @php
                    $koor = isset($koordinator) ? $koordinator->firstWhere('bidang', $num) : null;
                @endphp
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="badge bg-slate-100 text-slate-800 font-bold text-xs border border-slate-200">Sekbid {{ $num }}</span>
                            <span class="text-2xl">{{ $info['emoji'] }}</span>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 leading-snug">{{ $info['nama'] }}</h3>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $info['tugas'] }}</p>

                        <div class="mt-4 pt-3 border-t border-slate-100">
                            <p class="text-[11px] uppercase tracking-wider text-slate-400 font-bold">Koordinator Bidang</p>
                            @if($koor)
                                <p class="text-xs font-semibold text-slate-800 mt-0.5">{{ $koor->name }}</p>
                            @else
                                <p class="text-xs text-slate-400 mt-0.5 italic">Belum ditetapkan</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 pt-2">
                        <a href="/organisasi/sekbid/{{ $num }}"
                           class="w-full text-center inline-block py-1.5 px-3 rounded-lg border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-navy transition-colors">
                            Buka Profil & Program &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ────────────────────────────────────────────── --}}
    {{-- 6. ARSIP PENGURUS TERDAHULU --}}
    {{-- ────────────────────────────────────────────── --}}
    @if(isset($arsip) && $arsip->count() > 0)
        @php
            $arsipGrouped = $arsip->groupBy('periode');
        @endphp
        <div class="mb-12">
            <button onclick="document.getElementById('arsipContent').classList.toggle('hidden')"
                    class="w-full flex items-center justify-between bg-white border border-slate-200 rounded-2xl px-6 py-4 hover:bg-slate-50 transition-colors shadow-sm">
                <span class="flex items-center gap-3 text-sm font-bold text-slate-800">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                    Arsip Pengurus OSIS-MPR Terdahulu
                    <span class="badge bg-slate-100 text-slate-500 font-semibold text-xs">{{ $arsip->count() }} Tokoh Tercatat</span>
                </span>
                <span class="text-xs text-navy font-semibold flex items-center gap-1">
                    Buka / Tutup Arsip
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </span>
            </button>

            <div id="arsipContent" class="hidden mt-4">
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-6">
                    @foreach($arsipGrouped as $periode => $members)
                        <div class="border-b border-slate-100 pb-5 last:border-b-0 last:pb-0">
                            <span class="badge bg-navy/10 text-navy font-bold text-xs mb-3">Masa Bakti Periode {{ $periode ?: 'Sebelumnya' }}</span>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 mt-2">
                                @foreach($members as $m)
                                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-3 text-center">
                                        <div class="w-10 h-10 rounded-full bg-slate-200 text-slate-700 font-bold text-sm flex items-center justify-center mx-auto mb-1.5">
                                            {{ strtoupper(substr($m->name, 0, 1)) }}
                                        </div>
                                        <p class="text-xs font-bold text-slate-800 truncate">{{ $m->name }}</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5 truncate">{{ $m->jabatan ?? ucfirst(str_replace('_',' ',$m->role)) }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

</div>
@endsection
