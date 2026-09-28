@extends('layouts.app')
@section('title', 'Beranda')

@section('content')

{{-- ══════════════════════════════════════════════ HERO ══════════════════════════ --}}
<section class="relative bg-white border-b border-slate-200 overflow-hidden">
    <div class="absolute inset-0" style="background-image:linear-gradient(to right,#0f172a06 1px,transparent 1px),linear-gradient(to bottom,#0f172a06 1px,transparent 1px);background-size:32px 32px;"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28 text-center">
        <div class="inline-flex items-center gap-2 text-xs font-semibold px-3 py-1.5 rounded-full mb-6"
             style="background:#EFF6FF;color:#1E3A8A;border:1px solid #BFDBFE;">
            <span class="w-1.5 h-1.5 rounded-full" style="background:#1E3A8A;"></span>
            Platform Resmi OSIS-MPR SMKS Wikrama Bogor
        </div>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight mb-6">
            WIKRAMA<span style="color:#1E3A8A;">-ORBIT</span>
        </h1>
        <p class="max-w-2xl mx-auto text-base md:text-lg text-slate-500 leading-relaxed mb-10">
            Satu platform terpadu untuk manajemen organisasi OSIS-MPR, program kerja bidang, regulasi kedisiplinan, bimbingan prestasi, dan transparansi aspirasi siswa SMKS Wikrama Bogor.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="/organisasi" class="btn-primary px-6 py-3 rounded-xl shadow-sm" style="font-size:0.875rem;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Lihat Struktur Organisasi
            </a>
            <a href="/aspirasi" class="inline-flex items-center gap-2 border border-slate-200 bg-white text-slate-700 font-semibold px-6 py-3 rounded-xl hover:bg-slate-50 transition-colors shadow-sm" style="font-size:0.875rem;text-decoration:none;">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                Sampaikan Aspirasi ke MPR
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════ FEATURE CARDS ROW ════════════════════ --}}
<section class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        <a href="/organisasi" class="group bg-white border border-slate-200 rounded-xl p-5 hover:shadow-md hover:border-slate-300 transition-all" style="text-decoration:none;">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-4" style="background:#EFF6FF;">
                <svg class="w-5 h-5" style="color:#1E3A8A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <h3 class="font-semibold text-slate-800 text-sm mb-1 group-hover:text-navy transition-colors">Struktur Organisasi</h3>
            <p class="text-xs text-slate-500 leading-relaxed">Pembina, Dewan Penasihat, MPR, Dewan Harian, dan 10 Seksi Bidang.</p>
        </a>

        <a href="/aspirasi" class="group bg-white border border-slate-200 rounded-xl p-5 hover:shadow-md hover:border-slate-300 transition-all" style="text-decoration:none;">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-4" style="background:#F0FDF4;">
                <svg class="w-5 h-5" style="color:#059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            </div>
            <h3 class="font-semibold text-slate-800 text-sm mb-1 group-hover:text-emerald transition-colors">Aspirasi MPR</h3>
            <p class="text-xs text-slate-500 leading-relaxed">Sampaikan aspirasi ke MPR — ditampilkan transparan dan ditanggapi langsung.</p>
        </a>

        <a href="/live-events" class="group bg-white border border-slate-200 rounded-xl p-5 hover:shadow-md hover:border-slate-300 transition-all" style="text-decoration:none;">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-4" style="background:#FEF3C7;">
                <svg class="w-5 h-5" style="color:#D97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <h3 class="font-semibold text-slate-800 text-sm mb-1 transition-colors">Live Event & Voting</h3>
            <p class="text-xs text-slate-500 leading-relaxed">Pemilu OSIS, lomba bagan, voting umum — real count langsung di sini.</p>
        </a>

        <a href="/piket" class="group bg-white border border-slate-200 rounded-xl p-5 hover:shadow-md hover:border-slate-300 transition-all" style="text-decoration:none;">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-4" style="background:#F5F3FF;">
                <svg class="w-5 h-5" style="color:#7C3AED;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="font-semibold text-slate-800 text-sm mb-1 transition-colors">Jadwal Piket GDS</h3>
            <p class="text-xs text-slate-500 leading-relaxed">Cek jadwal piket GDS kamu — kapan giliran dan siapa yang bertugas.</p>
        </a>

    </div>
</section>

{{-- ══════════════════════════════════ SECTION: SEKSI BIDANG ════════════════════ --}}
<section class="py-12 md:py-16 bg-white border-y border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h2 class="text-xl md:text-2xl font-bold text-slate-900 mb-1">10 Seksi Bidang OSIS</h2>
            <p class="text-sm text-slate-500">Setiap bidang menjalankan program kerja sesuai fungsinya masing-masing.</p>
        </div>
        @php
            $sekbids = [
                1  => ['emoji'=>'🕌','nama'=>'Keimanan & Ketakwaan','color'=>'#16A34A','bg'=>'#F0FDF4'],
                2  => ['emoji'=>'✨','nama'=>'Budi Pekerti & Akhlak','color'=>'#B45309','bg'=>'#FFFBEB'],
                3  => ['emoji'=>'🇮🇩','nama'=>'Kepribadian & Bela Negara','color'=>'#DC2626','bg'=>'#FEF2F2'],
                4  => ['emoji'=>'🏆','nama'=>'Prestasi & Olahraga','color'=>'#7C3AED','bg'=>'#F5F3FF'],
                5  => ['emoji'=>'🌿','nama'=>'Demokrasi & Lingkungan','color'=>'#059669','bg'=>'#F0FDF4'],
                6  => ['emoji'=>'💡','nama'=>'Kreativitas & Wirausaha','color'=>'#EA580C','bg'=>'#FFF7ED'],
                7  => ['emoji'=>'🥗','nama'=>'Kesehatan & Gizi','color'=>'#0D9488','bg'=>'#F0FDFA'],
                8  => ['emoji'=>'🎭','nama'=>'Sastra & Budaya','color'=>'#DB2777','bg'=>'#FDF2F8'],
                9  => ['emoji'=>'💻','nama'=>'Teknologi Informasi','color'=>'#1D4ED8','bg'=>'#EFF6FF'],
                10 => ['emoji'=>'🌐','nama'=>'Komunikasi Bhs. Inggris','color'=>'#4338CA','bg'=>'#EEF2FF'],
            ];
        @endphp
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
            @foreach($sekbids as $num => $sek)
            <a href="/organisasi/sekbid/{{ $num }}" class="flex flex-col items-center text-center p-4 rounded-xl border border-slate-200 bg-white hover:shadow-md transition-all" style="text-decoration:none;">
                <span class="text-2xl mb-2">{{ $sek['emoji'] }}</span>
                <span class="text-xs font-bold rounded-full px-2 py-0.5 mb-1" style="background:{{ $sek['bg'] }};color:{{ $sek['color'] }};">Sekbid {{ $num }}</span>
                <span class="text-xs text-slate-600 font-medium leading-tight">{{ $sek['nama'] }}</span>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════ SECTION: LIVE PROKER ════════════════════ --}}
<section class="py-12 md:py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-xl md:text-2xl font-bold text-slate-900">Program Kerja Aktif</h2>
            <p class="text-sm text-slate-500 mt-1">Pantau kegiatan yang sedang dijalankan oleh OSIS-MPR Wikrama.</p>
        </div>
        <a href="/dashboard" class="inline-flex items-center gap-2 text-sm font-semibold text-navy hover:text-navy-dark transition-colors" style="text-decoration:none;color:#1E3A8A;">
            Lihat semua di Dashboard
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
    @php
        $prokers = \App\Models\KegiatanOsis::where('status', 0)->orderBy('target_selesai')->take(6)->get();
    @endphp
    @if($prokers->isEmpty())
        <div class="text-center py-12 text-slate-400 bg-white border border-dashed border-slate-200 rounded-xl">
            <p class="text-sm">Belum ada program kerja aktif.</p>
        </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($prokers as $proker)
        @php
            $isOverdue = $proker->target_selesai < now() && $proker->status == 0;
            $katColors = [
                'Regulasi GDS'       => ['bg'=>'#EFF6FF','color'=>'#1D4ED8','border'=>'#BFDBFE'],
                'Bimbingan Prestasi' => ['bg'=>'#F5F3FF','color'=>'#6D28D9','border'=>'#DDD6FE'],
                'Program Kerja'      => ['bg'=>'#F0FDF4','color'=>'#065F46','border'=>'#A7F3D0'],
                'Aspirasi MPR'       => ['bg'=>'#FFF7ED','color'=>'#C2410C','border'=>'#FED7AA'],
            ];
            $kc = $katColors[$proker->kategori] ?? ['bg'=>'#F8FAFC','color'=>'#475569','border'=>'#E2E8F0'];
        @endphp
        <div class="bg-white border border-slate-200 rounded-xl p-5 hover:shadow-sm transition-shadow" style="{{ $isOverdue ? 'border-color:#FCA5A5;' : '' }}">
            <div class="flex items-start justify-between gap-2 mb-3">
                <span class="badge" style="background:{{ $kc['bg'] }};color:{{ $kc['color'] }};border:1px solid {{ $kc['border'] }};">{{ $proker->kategori }}</span>
                @if($isOverdue)
                    <span class="badge" style="background:#FEF2F2;color:#DC2626;border:1px solid #FCA5A5;">Lewat Tenggat</span>
                @else
                    <span class="badge" style="background:#FFFBEB;color:#B45309;border:1px solid #FDE68A;">Berlangsung</span>
                @endif
            </div>
            <h3 class="font-semibold text-slate-900 text-sm leading-snug mb-2">{{ $proker->title }}</h3>
            <p class="text-xs text-slate-500 mb-3">PIC: {{ $proker->penanggung_jawab }}</p>
            <div class="flex items-center gap-1.5 text-xs text-slate-400">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Target: {{ $proker->target_selesai->format('d M Y, H:i') }} WIB
            </div>
        </div>
        @endforeach
    </div>
    @endif
</section>

{{-- ══════════════════════════════════ SECTION: ASPIRASI & LIVE EVENT ═══════════ --}}
<section class="bg-white border-t border-slate-200 py-12 md:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Aspirasi MPR --}}
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 md:p-8">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-5" style="background:#F0FDF4;">
                    <svg class="w-5 h-5" style="color:#059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                </div>
                <h3 class="font-bold text-slate-900 text-base mb-2">Aspirasi MPR — Terbuka & Transparan</h3>
                <p class="text-sm text-slate-500 mb-6 leading-relaxed">Setiap siswa dan guru dapat menyampaikan aspirasi secara langsung kepada MPR. Semua aspirasi dipublikasikan dan ditanggapi.</p>
                @php $totalAspirasi = \App\Models\Aspirasi::where('is_publik',1)->count(); @endphp
                <div class="flex items-center gap-3 mb-5">
                    <span class="text-2xl font-extrabold" style="color:#059669;">{{ $totalAspirasi }}</span>
                    <span class="text-sm text-slate-500">aspirasi terpublikasi</span>
                </div>
                <div class="flex gap-2">
                    <a href="/aspirasi" class="btn-primary" style="font-size:0.75rem;padding:0.5rem 1rem;background:#059669;">
                        Lihat Semua Aspirasi
                    </a>
                    <a href="https://forms.gle/contoh" target="_blank" class="inline-flex items-center gap-1.5 border border-slate-200 bg-white text-slate-600 text-xs font-medium px-3 py-2 rounded-lg hover:bg-slate-50 transition-colors" style="text-decoration:none;">
                        Via Google Form
                    </a>
                </div>
            </div>

            {{-- Live Events --}}
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 md:p-8">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-5" style="background:#FFFBEB;">
                    <svg class="w-5 h-5" style="color:#D97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <h3 class="font-bold text-slate-900 text-base mb-2">Live Event & Voting</h3>
                <p class="text-sm text-slate-500 mb-6 leading-relaxed">Pantau pemilu OSIS, voting lomba, atau event khusus. Lihat perolehan suara secara langsung tanpa perlu reload.</p>
                @php
                    $berlangsung = \App\Models\LiveEvent::where('status','berlangsung')->count();
                    $akanDatang  = \App\Models\LiveEvent::where('status','akan_datang')->count();
                @endphp
                <div class="flex items-center gap-4 mb-5">
                    @if($berlangsung > 0)
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full" style="background:#16A34A;animation:pulse 2s infinite;"></span>
                        <span class="text-sm font-semibold" style="color:#16A34A;">{{ $berlangsung }} Berlangsung</span>
                    </div>
                    @endif
                    @if($akanDatang > 0)
                    <span class="text-xs text-slate-500">{{ $akanDatang }} akan datang</span>
                    @endif
                    @if($berlangsung == 0 && $akanDatang == 0)
                    <span class="text-sm text-slate-400">Belum ada event aktif.</span>
                    @endif
                </div>
                <a href="/live-events" class="btn-primary" style="font-size:0.75rem;padding:0.5rem 1rem;background:#D97706;">
                    Buka Live Events
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════ SECTION: SEKBID SPOTLIGHTS ══════════════ --}}
<section class="py-12 md:py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h2 class="text-xl md:text-2xl font-bold text-slate-900">Sorotan Seksi Bidang</h2>
        <p class="text-sm text-slate-500 mt-1">Setiap bidang memiliki peran dan program kerja yang berbeda. Klik untuk mengenal lebih dalam.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        {{-- Sekbid 4: Prestasi --}}
        <div class="bg-white border border-slate-200 rounded-xl p-5 hover:shadow-md transition-shadow">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl shrink-0" style="background:#F5F3FF;">🏆</div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="badge" style="background:#F5F3FF;color:#7C3AED;border:1px solid #DDD6FE;">Sekbid 4</span>
                        <span class="text-xs text-slate-400">Prestasi & Olahraga</span>
                    </div>
                    <h3 class="font-semibold text-slate-800 text-sm mb-1">Bimbingan Prestasi & Kompetisi</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Pendampingan siswa berprestasi, delegasi kompetisi lokal hingga internasional, dan pengembangan bakat akademik.</p>
                    <a href="/organisasi/sekbid/4" class="inline-flex items-center gap-1 text-xs font-semibold mt-3 transition-colors" style="color:#7C3AED;text-decoration:none;">
                        Lihat Profil Sekbid 4 →
                    </a>
                </div>
            </div>
        </div>

        {{-- Sekbid 9: TIK --}}
        <div class="bg-white border border-slate-200 rounded-xl p-5 hover:shadow-md transition-shadow">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl shrink-0" style="background:#EFF6FF;">💻</div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="badge" style="background:#EFF6FF;color:#1D4ED8;border:1px solid #BFDBFE;">Sekbid 9</span>
                        <span class="text-xs text-slate-400">Teknologi Informasi</span>
                    </div>
                    <h3 class="font-semibold text-slate-800 text-sm mb-1">Inovasi Teknologi & Komunikasi</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Memimpin digitalisasi kegiatan sekolah, pengelolaan media sosial OSIS, dan pelatihan literasi digital siswa.</p>
                    <a href="/organisasi/sekbid/9" class="inline-flex items-center gap-1 text-xs font-semibold mt-3 transition-colors" style="color:#1D4ED8;text-decoration:none;">
                        Lihat Profil Sekbid 9 →
                    </a>
                </div>
            </div>
        </div>

        {{-- Sekbid 5: Demokrasi & Lingkungan --}}
        <div class="bg-white border border-slate-200 rounded-xl p-5 hover:shadow-md transition-shadow">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl shrink-0" style="background:#F0FDF4;">🌿</div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="badge" style="background:#F0FDF4;color:#065F46;border:1px solid #A7F3D0;">Sekbid 5</span>
                        <span class="text-xs text-slate-400">Demokrasi & Lingkungan</span>
                    </div>
                    <h3 class="font-semibold text-slate-800 text-sm mb-1">Regulasi Kedisiplinan & GDS</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Mengawal program GDS (Gerakan Disiplin Siswa) bersama Sekbid 2 sebagai salah satu program kerja harian aktif.</p>
                    <a href="/organisasi/sekbid/5" class="inline-flex items-center gap-1 text-xs font-semibold mt-3 transition-colors" style="color:#065F46;text-decoration:none;">
                        Lihat Profil Sekbid 5 →
                    </a>
                </div>
            </div>
        </div>

        {{-- Sekbid 6: Kreativitas --}}
        <div class="bg-white border border-slate-200 rounded-xl p-5 hover:shadow-md transition-shadow">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl shrink-0" style="background:#FFF7ED;">💡</div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="badge" style="background:#FFF7ED;color:#EA580C;border:1px solid #FDBA74;">Sekbid 6</span>
                        <span class="text-xs text-slate-400">Kreativitas & Kewirausahaan</span>
                    </div>
                    <h3 class="font-semibold text-slate-800 text-sm mb-1">Pengembangan Keterampilan & Wirausaha</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Memfasilitasi kegiatan wirausaha siswa, pameran kreasi, dan pelatihan keterampilan vokasional.</p>
                    <a href="/organisasi/sekbid/6" class="inline-flex items-center gap-1 text-xs font-semibold mt-3 transition-colors" style="color:#EA580C;text-decoration:none;">
                        Lihat Profil Sekbid 6 →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 text-center">
        <a href="/organisasi" class="inline-flex items-center gap-2 border border-slate-200 bg-white text-slate-600 text-sm font-medium px-5 py-2.5 rounded-xl hover:bg-slate-50 transition-colors" style="text-decoration:none;">
            Lihat Semua 10 Seksi Bidang →
        </a>
    </div>
</section>

{{-- ══════════════════════════════════ SECTION: PIKET HARI INI ════════════════ --}}
<section class="bg-white border-t border-slate-200 py-12 md:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-slate-900">Jadwal Piket GDS Hari Ini</h2>
                <p class="text-sm text-slate-500 mt-1">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
            </div>
            <a href="/piket" class="inline-flex items-center gap-2 text-sm font-semibold transition-colors" style="color:#1E3A8A;text-decoration:none;">
                Lihat Jadwal Mingguan →
            </a>
        </div>
        @auth
            @if(Auth::user()->role != 'warga')
                @php
                    $piketHariIni = \App\Models\PiketGds::where('tanggal', now()->toDateString())->get();
                @endphp
                @if($piketHariIni->isEmpty())
                    <div class="bg-slate-50 border border-dashed border-slate-200 rounded-xl py-8 text-center">
                        <p class="text-sm text-slate-400">Tidak ada jadwal piket GDS terdaftar untuk hari ini.</p>
                        <a href="/piket" class="text-xs text-navy mt-2 inline-block" style="color:#1E3A8A;">Lihat jadwal lengkap →</a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($piketHariIni as $p)
                        <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-sm font-bold shrink-0" style="background:#1E3A8A;">
                                {{ strtoupper(substr($p->nama_petugas, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-800">{{ $p->nama_petugas }}</p>
                                <p class="text-xs text-slate-500">{{ $p->jabatan_petugas }} · Shift {{ $p->shift }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            @else
                <div class="bg-blue-50 border border-blue-200 rounded-xl py-8 text-center">
                    <p class="text-sm text-blue-800 font-medium">Hanya pengurus OSIS yang dapat melihat jadwal GDS.</p>
                </div>
            @endif
        @else
            <div class="bg-blue-50 border border-blue-200 rounded-xl py-8 text-center">
                <p class="text-sm text-blue-800 font-medium">Login sebagai Anggota OSIS untuk melihat Jadwal GDS.</p>
                <a href="/login" class="text-xs text-navy mt-2 inline-block" style="color:#1E3A8A;">Login sekarang →</a>
            </div>
        @endauth
    </div>
</section>

@endsection
