@extends('layouts.app')
@section('title', 'Hub Konversi Figma — WIKRAMA-ORBIT')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-200 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full mb-3">
            🎨 Mode Preview Publik untuk Figma
        </div>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Hub Konversi UI/UX Figma</h1>
        <p class="text-slate-500 text-sm mt-1.5">
            Gunakan tautan di bawah ini untuk dimasukkan langsung ke plugin <span class="font-semibold text-slate-700">html.to.design</span> di Figma. Seluruh halaman di bawah ini dapat diakses bot tanpa perlu login!
        </p>
    </div>

    @php
        $links = [
            [
                'title' => 'Dashboard Kanban Program Kerja',
                'desc' => 'Tampilan papan Kanban 4 kolom, progress bar per proker, status prioritas, dan filter Sekbid.',
                'url' => url('/preview-ui/dashboard'),
                'type' => 'Desktop (1440x900)',
                'badge' => 'Kanban',
                'color' => 'blue',
            ],
            [
                'title' => 'Database Anggota OSIS-MPR (Monitoring)',
                'desc' => 'Tabel pengurus lengkap, status aktif/demisioner, tombol Tambah Manual & modal Import Excel.',
                'url' => url('/preview-ui/monitoring'),
                'type' => 'Desktop (1440x900)',
                'badge' => 'Database',
                'color' => 'indigo',
            ],
            [
                'title' => 'Pencatatan Pelanggaran GDS (Gerbang)',
                'desc' => 'Halaman pencatatan pelanggaran cepat mobile-first di gerbang sekolah dengan 10 jenis pelanggaran.',
                'url' => url('/preview-ui/pelanggaran'),
                'type' => 'Mobile (390x844)',
                'badge' => 'Mobile-First',
                'color' => 'rose',
            ],
            [
                'title' => 'Rekap Absensi Piket GDS',
                'desc' => 'Monitoring kehadiran pengurus saat piket (hadir/terlambat/tidak hadir beserta poin pelanggaran).',
                'url' => url('/preview-ui/absensi'),
                'type' => 'Desktop (1440x900)',
                'badge' => 'Absensi',
                'color' => 'amber',
            ],
            [
                'title' => 'Jadwal Piket GDS Mingguan',
                'desc' => 'Tabel penugasan harian pengurus OSIS-MPR, pembagian jobdesk dan pos penempatan.',
                'url' => url('/preview-ui/piket'),
                'type' => 'Desktop (1440x900)',
                'badge' => 'Jadwal',
                'color' => 'teal',
            ],
            [
                'title' => 'Pembukuan Kas Keuangan OSIS',
                'desc' => 'Arus kas masuk dan keluar per kegiatan, kartu saldo real-time, dan arsip nota fisik.',
                'url' => url('/preview-ui/keuangan'),
                'type' => 'Desktop (1440x900)',
                'badge' => 'Keuangan',
                'color' => 'emerald',
            ],
            [
                'title' => 'Landing Page Depan (Publik)',
                'desc' => 'Halaman utama selamat datang, profil 10 Sekbid, dan transparansi kegiatan.',
                'url' => url('/'),
                'type' => 'Desktop / Mobile',
                'badge' => 'Publik',
                'color' => 'slate',
            ],
            [
                'title' => 'Halaman Masuk (Login 2-Step)',
                'desc' => 'Form autentikasi resmi pengurus dan warga sekolah.',
                'url' => url('/login'),
                'type' => 'Desktop (Centering)',
                'badge' => 'Auth',
                'color' => 'slate',
            ],
            [
                'title' => 'Halaman Registrasi Warga',
                'desc' => 'Form pendaftaran mandiri khusus domain @smkwikrama.sch.id.',
                'url' => url('/register'),
                'type' => 'Desktop (Centering)',
                'badge' => 'Auth',
                'color' => 'slate',
            ],
            [
                'title' => 'Kanal Aspirasi Siswa MPR',
                'desc' => 'Feed publik penyampaian aspirasi siswa dan tanggapan resmi pengurus MPR.',
                'url' => url('/aspirasi'),
                'type' => 'Desktop (1440x900)',
                'badge' => 'Aspirasi',
                'color' => 'purple',
            ],
            [
                'title' => 'Live Events & Pemilihan Raya OSIS',
                'desc' => 'Katalog bilik suara pemilihan ketua umum OSIS dan voting karya.',
                'url' => url('/live-events'),
                'type' => 'Desktop (1440x900)',
                'badge' => 'Voting',
                'color' => 'sky',
            ],
            [
                'title' => 'Struktur Organisasi OSIS-MPR',
                'desc' => 'Profil pembina, dewan penasihat, dewan harian, dan rincian 10 seksi bidang.',
                'url' => url('/organisasi'),
                'type' => 'Desktop (1440x900)',
                'badge' => 'Profil',
                'color' => 'cyan',
            ],
        ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($links as $item)
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs hover:border-slate-300 transition-all flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700">
                        {{ $item['badge'] }}
                    </span>
                    <span class="text-xs text-slate-400 font-medium">
                        📐 {{ $item['type'] }}
                    </span>
                </div>
                <h3 class="text-base font-bold text-slate-900">{{ $item['title'] }}</h3>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $item['desc'] }}</p>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                <input type="text" readonly value="{{ $item['url'] }}" 
                       class="text-xs bg-slate-50 border border-slate-200 text-slate-600 rounded-lg px-2.5 py-1.5 flex-1 select-all font-mono">
                <button type="button" onclick="navigator.clipboard.writeText('{{ $item['url'] }}'); alert('Tautan berhasil disalin! Silakan tempel di plugin Figma html.to.design.');"
                        class="bg-blue-800 hover:bg-blue-900 text-white text-xs font-semibold px-3 py-1.5 rounded-lg shrink-0 transition-colors cursor-pointer">
                    Salin Link
                </button>
                <a href="{{ $item['url'] }}" target="_blank" 
                   class="text-slate-400 hover:text-slate-700 p-1.5 rounded-lg hover:bg-slate-100 transition-colors" title="Buka di Tab Baru">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8 bg-amber-50 border border-amber-200 rounded-2xl p-4 text-xs text-amber-800">
        <p class="font-semibold mb-1">💡 Tips Import ke Figma:</p>
        <p>1. Buka Figma → Jalankan plugin <strong>html.to.design</strong>.</p>
        <p>2. Salin URL halaman yang diinginkan di atas, lalu tempel (*paste*) ke kotak URL di plugin Figma.</p>
        <p>3. Untuk halaman <strong>Pencatatan Pelanggaran GDS</strong>, di plugin Figma pilih preset <strong>Mobile (misal: iPhone 14/15)</strong> agar tampilan mobile-first-nya langsung pas!</p>
        <p>4. Untuk halaman lainnya, pilih preset <strong>Desktop (1440px)</strong>.</p>
    </div>
</div>
@endsection
