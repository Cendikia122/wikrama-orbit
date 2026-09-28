@extends('layouts.app')
@section('title', 'Seksi Bidang ' . $nomor . ' – ' . $info['nama'])

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- ── Breadcrumb ── --}}
    <div class="flex items-center gap-2 text-xs text-slate-400 mb-6">
        <a href="/organisasi" class="hover:text-slate-600 transition-colors">Struktur Organisasi</a>
        <span>&rsaquo;</span>
        <span class="text-slate-600 font-medium">Seksi Bidang {{ $nomor }}</span>
    </div>

    @php
        $mentorshipData = [
            1 => [
                'tagline' => 'Penguatan Karakter Religius & Toleransi Beragama',
                'pembimbing' => 'Koordinator Bidang 1 & Rohis / Rokris Wikrama',
                'tips' => [
                    ['icon' => '🤲', 'title' => 'Ibadah Tepat Waktu', 'desc' => 'Menjaga sholat berjamaah & kebaktian rutin sebagai pondasi integritas siswa.'],
                    ['icon' => '🤝', 'title' => 'Toleransi Antar Umat', 'desc' => 'Menghargai keberagaman keyakinan di lingkungan sekolah dengan prinsip saling menghormati.'],
                    ['icon' => '📖', 'title' => 'Kajian Rutin & Keputrian', 'desc' => 'Memfasilitasi peningkatan wawasan spiritual harian bagi seluruh siswa Wikrama.']
                ],
                'cta' => 'Gabung Forum Rohis/Rokris & Kajian',
                'wa' => 'https://wa.me/6281234567890?text=Halo+Sekbid+1+Wikrama,+saya+ingin+gabung+kajian'
            ],
            2 => [
                'tagline' => 'Penegakan Budi Pekerti Luhur & Budaya Tertib Wikrama',
                'pembimbing' => 'Koordinator Bidang 2 & Tim GDS (Gerakan Disiplin Siswa)',
                'tips' => [
                    ['icon' => '👞', 'title' => 'Atribut Sesuai Standar', 'desc' => 'Memastikan sepatu pantofel hitam polos, kaos kaki putih betis, dan sabuk terpasang.'],
                    ['icon' => '⏰', 'title' => 'Tepat Waktu Sebelum 07.15', 'desc' => 'Hadir sebelum gerbang ditutup untuk kelancaran pembelajaran dan penilaian sikap.'],
                    ['icon' => '🤝', 'title' => 'Senyum, Sapa, Salam (3S)', 'desc' => 'Menerapkan budaya sopan santun kepada guru, tamu, dan sesama teman setiap saat.']
                ],
                'cta' => 'Konsultasi Regulasi Kedisiplinan & Sikap',
                'wa' => 'https://wa.me/6281234567890?text=Halo+Sekbid+2+Wikrama,+saya+ingin+tanya+regulasi'
            ],
            3 => [
                'tagline' => 'Jiwa Patriotik, Kepemimpinan, & Tanggung Jawab Kebangsaan',
                'pembimbing' => 'Koordinator Bidang 3 & Pasukan Pengibar Bendera (Paskibra)',
                'tips' => [
                    ['icon' => '🇮🇩', 'title' => 'Khidmat Upacara Bendera', 'desc' => 'Menghargai jasa pahlawan lewat kedisiplinan baris-berbaris dan upacara rutin.'],
                    ['icon' => '🛡️', 'title' => 'Ketahanan Pribadi & Sikap', 'desc' => 'Melatih ketahanan fisik, mental anti-bullying, dan kepedulian sosial tinggi.'],
                    ['icon' => '🎖️', 'title' => 'Wawasan Nusantara', 'desc' => 'Memahami nilai-nilai Pancasila dan penerapannya dalam kehidupan modern.']
                ],
                'cta' => 'Gabung Latihan Kepemimpinan & Paskibra',
                'wa' => 'https://wa.me/6281234567890?text=Halo+Sekbid+3+Wikrama,+saya+tertarik+paskibra'
            ],
            4 => [
                'tagline' => 'Inkubasi Prestasi Akademik, Olahraga, & Kompetisi Internasional',
                'pembimbing' => 'Ketua OSIS 2 (Double International Awardee) & Sekbid 4',
                'tips' => [
                    ['icon' => '🌍', 'title' => 'Strategi Lomba Global', 'desc' => 'Riset kompetisi, penulisan esai ilmiah, dan persiapan presentasi standar internasional.'],
                    ['icon' => '⚡', 'title' => 'Time Management SMK', 'desc' => 'Keseimbangan produktif antara tugas kejuruan, proyek industri, dan latihan kompetisi.'],
                    ['icon' => '🥇', 'title' => 'Mentorship Juara', 'desc' => 'Bimbingan 1-on-1 bersama alumni dan delegasi pemenang lomba nasional/internasional.']
                ],
                'cta' => '🚀 Gabung Channel WhatsApp Info Lomba & Bimbingan Juara',
                'wa' => 'https://wa.me/6281234567890?text=Halo+Sekbid+4+Prestasi,+saya+ingin+mentorship+lomba'
            ],
            5 => [
                'tagline' => 'Demokrasi Kampus, Hak Asasi Siswa, & Wikrama Zero Waste',
                'pembimbing' => 'Koordinator Bidang 5 & Tim Gerakan Peduli Lingkungan Hidup',
                'tips' => [
                    ['icon' => '🍱', 'title' => 'Wajib Misting & Tumbler', 'desc' => 'Menolak plastik sekali pakai dengan membawa tempat makan dan botol minum sendiri.'],
                    ['icon' => '🗳️', 'title' => 'Partisipasi Demokrasi', 'desc' => 'Mengawal pemilu OSIS yang jujur, adil, terbuka, dan mendengarkan aspirasi siswa.'],
                    ['icon' => '🌱', 'title' => 'Pilah Sampah Sejak Meja', 'desc' => 'Membuang sampah terpilah (organik, anorganik, residu) sesuai pos penampungan.']
                ],
                'cta' => 'Dukung Gerakan Zero Waste & Demokrasi Wikrama',
                'wa' => 'https://wa.me/6281234567890?text=Halo+Sekbid+5+Wikrama,+saya+ingin+partisipasi+lingkungan'
            ],
            6 => [
                'tagline' => 'Jiwa Enterpreneurship, Karya Kreatif, & Produk Vokasi',
                'pembimbing' => 'Koordinator Bidang 6 & Wikrama Creative Hub',
                'tips' => [
                    ['icon' => '💡', 'title' => 'Monetisasi Keterampilan Kejuruan', 'desc' => 'Mengubah proyek coding, desain, atau kuliner menjadi produk bernilai jual.'],
                    ['icon' => '🛒', 'title' => 'Bazar & Expo Siswa', 'desc' => 'Pelatihan promosi produk siswa dalam ajang pameran dan bazar sekolah.'],
                    ['icon' => '📊', 'title' => 'Literasi Keuangan Pemula', 'desc' => 'Menghitung harga pokok penjualan (HPP) dan menyusun pembukuan sederhana.']
                ],
                'cta' => 'Gabung Komunitas Wirausaha Siswa Wikrama',
                'wa' => 'https://wa.me/6281234567890?text=Halo+Sekbid+6+Wikrama,+saya+punya+ide+bisnis'
            ],
            7 => [
                'tagline' => 'Kebugaran Jasmani, Gizi Berimbang, & Kesehatan Mental',
                'pembimbing' => 'Koordinator Bidang 7 & Tim Palang Merah Remaja (PMR)',
                'tips' => [
                    ['icon' => '🏃', 'title' => 'Senam & Gerak Aktif', 'desc' => 'Mengikuti kegiatan olahraga mingguan untuk menjaga daya tahan tubuh siswa.'],
                    ['icon' => '🥗', 'title' => 'Isi Piringku & Sarapan', 'desc' => 'Membiasakan sarapan bergizi sebelum jam 06.00 WIB untuk fokus belajar.'],
                    ['icon' => '🧠', 'title' => 'Kesehatan Mental Positif', 'desc' => 'Pencegahan stres belajar lewat konseling sebaya dan rehat teratur.']
                ],
                'cta' => 'Konsultasi Kesehatan & Olahraga Bersama Sekbid 7',
                'wa' => 'https://wa.me/6281234567890?text=Halo+Sekbid+7+Wikrama,+saya+ingin+tanya+program+sehat'
            ],
            8 => [
                'tagline' => 'Apresiasi Sastra Nusantara, Seni Rupa, & Teater Budaya',
                'pembimbing' => 'Koordinator Bidang 8 & Komunitas Seni Sastra Wikrama',
                'tips' => [
                    ['icon' => '📖', 'title' => 'Gerakan Literasi 15 Menit', 'desc' => 'Membaca buku non-pelajaran sebelum jam KBM dimulai untuk memperkaya wawasan.'],
                    ['icon' => '🎭', 'title' => 'Eksplorasi Minat Seni', 'desc' => 'Penyaluran bakat tari, musik akustik, puisi, dan teater dalam event sekolah.'],
                    ['icon' => '✍️', 'title' => 'Penerbitan Mading & Zine', 'desc' => 'Mempublikasikan karya tulis siswa pada mading fisik dan platform digital ORBIT.']
                ],
                'cta' => 'Kirimkan Karya Puisi, Cerpen, atau Musikmu',
                'wa' => 'https://wa.me/6281234567890?text=Halo+Sekbid+8+Wikrama,+saya+ingin+kirim+karya'
            ],
            9 => [
                'tagline' => 'Inovasi Teknologi, Rekayasa Perangkat Lunak, & Keamanan Siber',
                'pembimbing' => 'Koordinator Bidang 9 & Tim Developer WIKRAMA-ORBIT',
                'tips' => [
                    ['icon' => '💻', 'title' => 'Coding & Pembuatan Aplikasi', 'desc' => 'Memfasilitasi kelompok belajar framework Laravel, React, dan Flutter.'],
                    ['icon' => '🔒', 'title' => 'Etika Siber & Keamanan Akun', 'desc' => 'Menjaga kerahasiaan password dan etika berkomentar di media sosial.'],
                    ['icon' => '📱', 'title' => 'Pengelolaan Media Digital OSIS', 'desc' => 'Kreator konten grafis, video dokumentasi, dan sistem informasi sekolah.']
                ],
                'cta' => 'Gabung Komunitas Developer & IT Wikrama',
                'wa' => 'https://wa.me/6281234567890?text=Halo+Sekbid+9+Wikrama,+saya+ingin+join+komunitas+IT'
            ],
            10 => [
                'tagline' => 'Kecakapan Komunikasi Global, Public Speaking, & Debat Bahasa Inggris',
                'pembimbing' => 'Koordinator Bidang 10 & Wikrama English Club (WEC)',
                'tips' => [
                    ['icon' => '🗣️', 'title' => 'Daily English Practice', 'desc' => 'Membiasakan percakapan sederhana dalam bahasa Inggris setiap hari Rabu (English Day).'],
                    ['icon' => '🎙️', 'title' => 'Master of Ceremony (MC)', 'desc' => 'Pelatihan membawakan acara formal dan semi-formal dalam bahasa Inggris.'],
                    ['icon' => '🏆', 'title' => 'Persiapan Lomba Debat (NSDC)', 'desc' => 'Latihan berpikir kritis dan menyampaikan argumen terstruktur dalam bahasa Inggris.']
                ],
                'cta' => 'Join Wikrama English Club & Speaking Sessions',
                'wa' => 'https://wa.me/6281234567890?text=Hello+Sekbid+10+Wikrama,+I+want+to+join+WEC'
            ],
        ];

        $mentor = $mentorshipData[$nomor] ?? $mentorshipData[4];
    @endphp

    {{-- ── Hero Section ── --}}
    <div class="bg-gradient-to-br from-slate-900 via-navy to-navy-dark text-white rounded-3xl p-8 mb-8 shadow-xl" style="background:linear-gradient(135deg,#0F172A 0%,#1E3A8A 50%,#0F172A 100%);">
        <div class="flex items-center gap-2 mb-3">
            <span class="badge bg-white/20 text-white text-xs font-bold">Seksi Bidang {{ $nomor }}</span>
            <span class="text-white/60 text-xs">OSIS SMKS Wikrama Bogor</span>
        </div>
        <div class="flex items-start gap-4">
            <span class="text-5xl shrink-0">{{ $info['emoji'] }}</span>
            <div>
                <h1 class="text-2xl md:text-3xl font-black text-white leading-tight">
                    {{ $info['full'] }}
                </h1>
                <p class="text-blue-200 text-sm mt-2 font-medium leading-relaxed">
                    {{ $mentor['tagline'] }}
                </p>
            </div>
        </div>

        {{-- Koordinator Info --}}
        <div class="mt-6 pt-5 border-t border-white/10 flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center font-bold text-white text-sm border border-white/30">
                    {{ $koordinator ? strtoupper(substr($koordinator->name, 0, 1)) : 'K' }}
                </div>
                <div>
                    <p class="text-xs text-blue-200">Koordinator Bidang Terpilih:</p>
                    <p class="text-sm font-bold text-white">{{ $koordinator->name ?? 'Pengurus Sekbid ' . $nomor }}</p>
                </div>
            </div>

            <a href="{{ $mentor['wa'] }}" target="_blank"
               class="btn-primary text-xs px-4 py-2 rounded-xl bg-white text-navy font-bold hover:bg-blue-50 transition-colors"
               style="background:#ffffff; color:#0F172A;">
                Hubungi Sekbid {{ $nomor }} via WhatsApp &rarr;
            </a>
        </div>
    </div>

    {{-- ── Mentorship & Tips Section ── --}}
    <div class="mb-10">
        <div class="mb-5">
            <h2 class="text-lg font-bold text-slate-900">Bimbingan & Mentorship Sekbid {{ $nomor }}</h2>
            <p class="text-xs text-slate-500 mt-0.5">Panduan praktis dan arahan pengembangan diri dari {{ $mentor['pembimbing'] }}.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            @foreach($mentor['tips'] as $t)
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-3xl mb-3">{{ $t['icon'] }}</div>
                    <h3 class="text-sm font-bold text-slate-900 mb-1">{{ $t['title'] }}</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">{{ $t['desc'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Direct CTA --}}
        <a href="{{ $mentor['wa'] }}" target="_blank"
           class="w-full flex items-center justify-center gap-2 bg-navy text-white font-bold px-6 py-4 rounded-2xl hover:bg-navy-dark transition-colors text-sm shadow-md"
           style="background:#1E3A8A;">
            <span>{{ $mentor['cta'] }}</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </a>
    </div>

    {{-- ── Program Kerja Aktif Bidang Ini ── --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-base font-bold text-slate-900">Program Kerja Terkait Sekbid {{ $nomor }}</h2>
                <p class="text-xs text-slate-500">Inisiatif dan kegiatan yang dijalankan di bawah naungan bidang ini.</p>
            </div>
            <span class="badge bg-slate-100 text-slate-600 text-xs font-semibold">{{ $kegiatan->count() }} Proker</span>
        </div>

        @if($kegiatan->count() > 0)
            <div class="divide-y divide-slate-100">
                @foreach($kegiatan as $k)
                    <div class="py-3.5 first:pt-0 last:pb-0 flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-bold text-slate-900">{{ $k->title }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">
                                PIC: {{ $k->penanggung_jawab }} &bull; Target: {{ \Carbon\Carbon::parse($k->target_selesai)->format('d M Y') }}
                            </p>
                        </div>
                        <span class="badge {{ $k->status ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }} text-xs shrink-0">
                            {{ $k->status ? '✓ Selesai' : 'Sedang Berjalan' }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-slate-400">
                <p class="text-sm">Belum ada kegiatan yang terdaftar khusus pada Sekbid {{ $nomor }}.</p>
                <a href="/dashboard" class="text-xs text-navy font-semibold mt-1 inline-block hover:underline">Tambah Proker di Dashboard</a>
            </div>
        @endif
    </div>

</div>
@endsection
