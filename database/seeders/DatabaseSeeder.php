<?php

namespace Database\Seeders;

use App\Models\AbsensiGds;
use App\Models\Aspirasi;
use App\Models\KegiatanOsis;
use App\Models\Keuangan;
use App\Models\LiveEvent;
use App\Models\LiveEventOption;
use App\Models\LiveEventVote;
use App\Models\PelanggaranGds;
use App\Models\PiketGds;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with complete, realistic Wikrama data.
     * STRICTLY FLAT TABLES — NO FOREIGN KEYS, NO RELATIONS (Exam Compliance).
     */
    public function run(): void
    {
        $now = Carbon::now();
        $password = Hash::make('password123');

        // ─────────────────────────────────────────────────────────
        // 1. USERS & STRUKTUR ORGANISASI OSIS-MPR
        // ─────────────────────────────────────────────────────────

        // A. Pembina OSIS
        User::create([
            'name'      => 'Pak Rizal',
            'username'  => 'rizal',
            'email'     => 'rizal@smkwikrama.sch.id',
            'password'  => $password,
            'role'      => 'pembina',
            'jabatan'   => 'Pembina OSIS',
            'bidang'    => 0,
            'angkatan'  => '2024/2025',
            'is_aktif'  => 1,
            'periode'   => '2024/2025',
        ]);

        // B. Dewan Penasihat
        User::create([
            'name'      => 'Kak Andi Pratama',
            'username'  => 'andi',
            'email'     => 'andi@smkwikrama.sch.id',
            'password'  => $password,
            'role'      => 'dewan_penasihat',
            'jabatan'   => 'Ketua Dewan Penasihat',
            'bidang'    => 0,
            'angkatan'  => '2023/2024',
            'is_aktif'  => 1,
            'periode'   => '2024/2025',
        ]);

        // C. Majelis Perwakilan Rakyat (MPR)
        User::create([
            'name'      => 'Ketua MPR Wikrama',
            'username'  => 'ktmpr',
            'email'     => 'mpr@smkwikrama.sch.id',
            'password'  => $password,
            'role'      => 'mpr',
            'jabatan'   => 'Ketua MPR',
            'bidang'    => 0,
            'angkatan'  => '2024/2025',
            'is_aktif'  => 1,
            'periode'   => '2024/2025',
        ]);

        // D. Dewan Harian (DH) — 9 Jabatan Lengkap
        $dewanHarianData = [
            ['name' => 'Fathan Al-Ghifari',  'username' => 'ketum',   'email' => 'ketum@smkwikrama.sch.id',   'jabatan' => 'Ketua Umum'],
            ['name' => 'Rafi Ahmad Fauzan',  'username' => 'ketua1',  'email' => 'ketua1@smkwikrama.sch.id',  'jabatan' => 'Ketua 1'],
            ['name' => 'Ketua OSIS 2',       'username' => 'ketua2',  'email' => 'ketua2@smkwikrama.sch.id',  'jabatan' => 'Ketua 2'],
            ['name' => 'Salma Nuraini',      'username' => 'sekum',   'email' => 'sekum@smkwikrama.sch.id',   'jabatan' => 'Sekretaris Umum'],
            ['name' => 'Dinda Prameswari',   'username' => 'sek1',    'email' => 'sek1@smkwikrama.sch.id',    'jabatan' => 'Sekretaris 1'],
            ['name' => 'Annisa Rahmawati',   'username' => 'sek2',    'email' => 'sek2@smkwikrama.sch.id',    'jabatan' => 'Sekretaris 2'],
            ['name' => 'Zahra Amelia',       'username' => 'bendum',  'email' => 'bendum@smkwikrama.sch.id',  'jabatan' => 'Bendahara Umum'],
            ['name' => 'Nabila Putri',       'username' => 'ben1',    'email' => 'ben1@smkwikrama.sch.id',    'jabatan' => 'Bendahara 1'],
            ['name' => 'Farhan Maulana',     'username' => 'ben2',    'email' => 'ben2@smkwikrama.sch.id',    'jabatan' => 'Bendahara 2'],
        ];

        foreach ($dewanHarianData as $dh) {
            User::create([
                'name'      => $dh['name'],
                'username'  => $dh['username'],
                'email'     => $dh['email'],
                'password'  => $password,
                'role'      => 'dewan_harian',
                'jabatan'   => $dh['jabatan'],
                'bidang'    => 0,
                'angkatan'  => '2024/2025',
                'is_aktif'  => 1,
                'periode'   => '2024/2025',
            ]);
        }

        // E. Koordinator Seksi Bidang 1 s/d 10
        $koorbidData = [
            1  => ['name' => 'Muhammad Ihsan',    'username' => 'korbid1',  'email' => 'korbid1@smkwikrama.sch.id'],
            2  => ['name' => 'Bintang Ramadhan',   'username' => 'korbid2',  'email' => 'korbid2@smkwikrama.sch.id'],
            3  => ['name' => 'Aldo Wiratama',      'username' => 'korbid3',  'email' => 'korbid3@smkwikrama.sch.id'],
            4  => ['name' => 'Koorbid Empat',      'username' => 'korbid4',  'email' => 'korbid4@smkwikrama.sch.id'],
            5  => ['name' => 'Bima Sakti',         'username' => 'korbid5',  'email' => 'korbid5@smkwikrama.sch.id'],
            6  => ['name' => 'Clara Shinta',       'username' => 'korbid6',  'email' => 'korbid6@smkwikrama.sch.id'],
            7  => ['name' => 'David Santoso',      'username' => 'korbid7',  'email' => 'korbid7@smkwikrama.sch.id'],
            8  => ['name' => 'Gita Gutawa',        'username' => 'korbid8',  'email' => 'korbid8@smkwikrama.sch.id'],
            9  => ['name' => 'Haikal Kamil',       'username' => 'korbid9',  'email' => 'korbid9@smkwikrama.sch.id'],
            10 => ['name' => 'Jessica Mila',       'username' => 'korbid10', 'email' => 'korbid10@smkwikrama.sch.id'],
        ];

        foreach ($koorbidData as $bid => $k) {
            User::create([
                'name'      => $k['name'],
                'username'  => $k['username'],
                'email'     => $k['email'],
                'password'  => $password,
                'role'      => 'koordinator_bidang',
                'jabatan'   => 'Koordinator Bidang ' . $bid,
                'bidang'    => $bid,
                'angkatan'  => '2024/2025',
                'is_aktif'  => 1,
                'periode'   => '2024/2025',
            ]);
        }

        // F. Akun Warga Wikrama (Untuk Testing Register & Aspirasi)
        User::create([
            'name'      => 'Siswa Warga Wikrama',
            'username'  => 'warga1',
            'email'     => 'warga1@smkwikrama.sch.id',
            'password'  => $password,
            'role'      => 'warga',
            'jabatan'   => null,
            'bidang'    => 0,
            'angkatan'  => '2024/2025',
            'is_aktif'  => 1,
            'periode'   => null,
        ]);

        // G. Arsip Kepengurusan Terdahulu (is_aktif = 0)
        $arsipData = [
            ['name' => 'Kak Dimas Ardiansyah', 'username' => 'dimas',  'email' => 'dimas@smkwikrama.sch.id',  'role' => 'dewan_harian', 'jabatan' => 'Ketua Umum', 'periode' => '2023/2024', 'angkatan' => '2023/2024'],
            ['name' => 'Kak Sarah Salsabila',  'username' => 'sarah',  'email' => 'sarah@smkwikrama.sch.id',  'role' => 'dewan_harian', 'jabatan' => 'Sekretaris Umum', 'periode' => '2023/2024', 'angkatan' => '2023/2024'],
            ['name' => 'Kak Fajar Nugraha',    'username' => 'fajar',  'email' => 'fajar@smkwikrama.sch.id',  'role' => 'mpr',          'jabatan' => 'Ketua MPR', 'periode' => '2023/2024', 'angkatan' => '2023/2024'],
            ['name' => 'Kak Reza Aditya',      'username' => 'reza',   'email' => 'reza@smkwikrama.sch.id',   'role' => 'dewan_harian', 'jabatan' => 'Ketua Umum', 'periode' => '2022/2023', 'angkatan' => '2022/2023'],
            ['name' => 'Kak Tiara Andini',     'username' => 'tiara',  'email' => 'tiara@smkwikrama.sch.id',  'role' => 'dewan_harian', 'jabatan' => 'Bendahara Umum', 'periode' => '2022/2023', 'angkatan' => '2022/2023'],
        ];

        foreach ($arsipData as $a) {
            User::create([
                'name'      => $a['name'],
                'username'  => $a['username'],
                'email'     => $a['email'],
                'password'  => $password,
                'role'      => $a['role'],
                'jabatan'   => $a['jabatan'],
                'bidang'    => 0,
                'angkatan'  => $a['angkatan'],
                'is_aktif'  => 0,
                'periode'   => $a['periode'],
            ]);
        }

        // ─────────────────────────────────────────────────────────
        // 2. KEGIATAN OSIS DENGAN FITUR KANBAN & PROGRESS
        // ─────────────────────────────────────────────────────────
        KegiatanOsis::create([
            'title'                => 'Pemeriksaan Atribut Gerakan Disiplin Siswa (GDS) Pagi',
            'penanggung_jawab'     => 'Seksi Ketertiban & Rayon',
            'kategori'             => 'Regulasi GDS',
            'target_selesai'       => $now->copy()->addDay()->setTime(5, 50, 0),
            'status'               => 0,
            'done_time'            => null,
            'catatan_evaluasi'     => 'Pemeriksaan sepatu pantofel pendek dan botol minum tumbler dipercepat di gerbang masuk agar gang sekolah bebas macet.',
            'kanban_status'        => 'inprogress',
            'prioritas'            => 'tinggi',
            'bidang_pic'           => 2,
            'persentase_selesai'   => 65,
            'nama_ketua_pelaksana' => 'Bintang Ramadhan',
        ]);

        KegiatanOsis::create([
            'title'                => 'Sosialisasi Delegasi Kompetisi Internasional',
            'penanggung_jawab'     => 'Sekbid 4 (Prestasi Siswa)',
            'kategori'             => 'Bimbingan Prestasi',
            'target_selesai'       => $now->copy()->addWeek()->setTime(8, 0, 0),
            'status'               => 0,
            'done_time'            => null,
            'catatan_evaluasi'     => 'Informasi lomba disebar secara masif melalui Channel WhatsApp resmi Ketua OSIS 2 ke seluruh perwakilan rayon.',
            'kanban_status'        => 'todo',
            'prioritas'            => 'tinggi',
            'bidang_pic'           => 4,
            'persentase_selesai'   => 20,
            'nama_ketua_pelaksana' => 'Ketua OSIS 2',
        ]);

        KegiatanOsis::create([
            'title'                => 'Sidang Pleno Aspirasi Rayon MPR Triwulan',
            'penanggung_jawab'     => 'Pengurus MPR Wikrama',
            'kategori'             => 'Aspirasi MPR',
            'target_selesai'       => $now->copy()->subDays(2),
            'status'               => 1,
            'done_time'            => $now->copy()->subDay(),
            'catatan_evaluasi'     => 'Notulensi terpusat di WIKRAMA-ORBIT terbukti mencegah miskomunikasi dan tidak ada lagi evaluasi yang hilang di grup WhatsApp.',
            'kanban_status'        => 'done',
            'prioritas'            => 'normal',
            'bidang_pic'           => 0,
            'persentase_selesai'   => 100,
            'nama_ketua_pelaksana' => 'Ketua MPR Wikrama',
        ]);

        KegiatanOsis::create([
            'title'                => 'Penegakan Larangan Sampah Kemasan Plastik Sekali Pakai',
            'penanggung_jawab'     => 'Sekbid Lingkungan Hidup',
            'kategori'             => 'Program Kerja',
            'target_selesai'       => $now->copy()->subDay()->setTime(7, 0, 0), // OVERDUE DEMO
            'status'               => 0,
            'done_time'            => null,
            'catatan_evaluasi'     => 'Sosialisasi membawa tempat makan misting dan tumbler perlu dikoordinasikan ulang dengan pihak pengelola kantin sekolah.',
            'kanban_status'        => 'blocked',
            'prioritas'            => 'kritis',
            'bidang_pic'           => 5,
            'persentase_selesai'   => 45,
            'nama_ketua_pelaksana' => 'Bima Sakti',
        ]);

        KegiatanOsis::create([
            'title'                => 'Bazar Karya Vokasi & Expo Kewirausahaan Siswa',
            'penanggung_jawab'     => 'Sekbid 6 (Kreativitas & Kewirausahaan)',
            'kategori'             => 'Program Kerja',
            'target_selesai'       => $now->copy()->addDays(5)->setTime(9, 0, 0),
            'status'               => 0,
            'done_time'            => null,
            'catatan_evaluasi'     => 'Koordinasi denah stand bazar di lapangan indoor dan perlengkapan meja telah selesai disiapkan bersama tim logistik.',
            'kanban_status'        => 'inprogress',
            'prioritas'            => 'normal',
            'bidang_pic'           => 6,
            'persentase_selesai'   => 50,
            'nama_ketua_pelaksana' => 'Clara Shinta',
        ]);

        KegiatanOsis::create([
            'title'                => 'Coding Bootcamp Laravel 13 & Cyber Security Literacy',
            'penanggung_jawab'     => 'Sekbid 9 (TIK)',
            'kategori'             => 'Bimbingan Prestasi',
            'target_selesai'       => $now->copy()->addDays(10)->setTime(13, 0, 0),
            'status'               => 0,
            'done_time'            => null,
            'catatan_evaluasi'     => 'Materi workshop backend Laravel 13 dan deployment aman telah dikurasi bersama instruktur kejuruan PPLG.',
            'kanban_status'        => 'todo',
            'prioritas'            => 'tinggi',
            'bidang_pic'           => 9,
            'persentase_selesai'   => 15,
            'nama_ketua_pelaksana' => 'Haikal Kamil',
        ]);

        // ─────────────────────────────────────────────────────────
        // 3. JADWAL PIKET GDS (HARI INI & MINGGU INI)
        // Format berdasarkan jadwal nyata: No | Nama | Divisi | Jobdesk | Penempatan
        // ─────────────────────────────────────────────────────────
        $todayStr = $now->toDateString();
        $tomorrowStr = $now->copy()->addDay()->toDateString();
        $in2DaysStr = $now->copy()->addDays(2)->toDateString();

        PiketGds::create([
            'tanggal'         => $todayStr,
            'hari'            => $now->isoFormat('dddd'),
            'nama_petugas'    => 'Kiran Nanda Malika Putri',
            'jabatan_petugas' => 'MPR',
            'bidang_petugas'  => 0,
            'shift'           => 'Pagi',
            'jobdesk'         => 'SIM',
            'penempatan'      => 'Parkiran',
            'divisi'          => 'MPR',
        ]);

        PiketGds::create([
            'tanggal'         => $todayStr,
            'hari'            => $now->isoFormat('dddd'),
            'nama_petugas'    => 'Naufal Abdilah',
            'jabatan_petugas' => 'Koordinator Bidang 4',
            'bidang_petugas'  => 4,
            'shift'           => 'Pagi',
            'jobdesk'         => 'Pengawas & Pencatat Atribut',
            'penempatan'      => 'Belakang',
            'divisi'          => 'SEKBID 4',
        ]);

        PiketGds::create([
            'tanggal'         => $todayStr,
            'hari'            => $now->isoFormat('dddd'),
            'nama_petugas'    => 'Rafka Athaya Khiry',
            'jabatan_petugas' => 'Koordinator Bidang 6',
            'bidang_petugas'  => 6,
            'shift'           => 'Pagi',
            'jobdesk'         => 'Tas',
            'penempatan'      => 'Belakang',
            'divisi'          => 'SEKBID 6',
        ]);

        PiketGds::create([
            'tanggal'         => $tomorrowStr,
            'hari'            => $now->copy()->addDay()->isoFormat('dddd'),
            'nama_petugas'    => 'Fathan Al-Ghifari',
            'jabatan_petugas' => 'Ketua Umum OSIS',
            'bidang_petugas'  => 0,
            'shift'           => 'Pagi',
            'jobdesk'         => 'SIM',
            'penempatan'      => 'Parkiran',
            'divisi'          => 'DH',
        ]);

        PiketGds::create([
            'tanggal'         => $in2DaysStr,
            'hari'            => $now->copy()->addDays(2)->isoFormat('dddd'),
            'nama_petugas'    => 'Hilman Nazhir Fikriyana',
            'jabatan_petugas' => 'MPR',
            'bidang_petugas'  => 0,
            'shift'           => 'Pagi',
            'jobdesk'         => 'Atribut Pria',
            'penempatan'      => 'Belakang',
            'divisi'          => 'MPR',
        ]);

        // ─────────────────────────────────────────────────────────
        // 4. LIVE EVENTS (PEMILU & VOTING BAGAN)
        // ─────────────────────────────────────────────────────────
        $event1 = LiveEvent::create([
            'judul'       => 'Pemilihan Raya Ketua Umum OSIS Masa Bakti 2026/2027',
            'deskripsi'   => 'Gunakan hak suaramu untuk menentukan suksesi kepemimpinan OSIS SMKS Wikrama Bogor. Satu suara menentukan arah kemajuan organisasi!',
            'jenis'       => 'pemilu',
            'status'      => 'berlangsung',
            'mulai_at'    => $now->copy()->subHours(4),
            'selesai_at'  => $now->copy()->addHours(20),
            'dibuat_oleh' => 'Ketua MPR Wikrama',
        ]);

        LiveEventOption::create([
            'live_event_id' => $event1->id,
            'nama_kandidat' => 'Paslon 01: Arya Wirasena & Citra Kirana',
            'foto'          => null,
            'deskripsi'     => 'Visi: Wikrama Adaptif, Kolaboratif, dan Berkarakter Global.',
            'jumlah_suara'  => 164,
        ]);

        LiveEventOption::create([
            'live_event_id' => $event1->id,
            'nama_kandidat' => 'Paslon 02: Dafa Al-Faris & Evelyn Putri',
            'foto'          => null,
            'deskripsi'     => 'Visi: Digitalisasi Total Proker Siswa & Pengawalan Prestasi Kejuruan.',
            'jumlah_suara'  => 192,
        ]);

        $event2 = LiveEvent::create([
            'judul'       => 'Voting Desain Maskot Dies Natalis Wikrama',
            'deskripsi'   => 'Pilih karya desain maskot terbaik kiriman siswa jurusan Desain Komunikasi Visual (DKV).',
            'jenis'       => 'voting_umum',
            'status'      => 'akan_datang',
            'mulai_at'    => $now->copy()->addDays(3),
            'selesai_at'  => $now->copy()->addDays(7),
            'dibuat_oleh' => 'Clara Shinta',
        ]);

        LiveEventOption::create([
            'live_event_id' => $event2->id,
            'nama_kandidat' => 'Konsep A - "Wikra Sang Kancil Cerdas"',
            'jumlah_suara'  => 0,
        ]);

        LiveEventOption::create([
            'live_event_id' => $event2->id,
            'nama_kandidat' => 'Konsep B - "Garuda Siber Wikrama"',
            'jumlah_suara'  => 0,
        ]);

        // ─────────────────────────────────────────────────────────
        // 5. ASPIRASI MPR
        // ─────────────────────────────────────────────────────────
        Aspirasi::create([
            'judul'          => 'Penambahan stopkontak dan colokan charger di area selasar gedung B',
            'isi'            => 'Banyak siswa yang kesulitan mengisi daya laptop saat mengerjakan tugas kejuruan di luar jam kelas karena stopkontak yang tersedia sangat terbatas.',
            'nama_pengirim'  => 'Siswa Warga Wikrama',
            'email_pengirim' => 'warga1@smkwikrama.sch.id',
            'role_pengirim'  => 'warga',
            'status'         => 'selesai',
            'tanggapan'      => 'MPR telah menyampaikan aspirasi ini ke bagian Sarana Prasarana Sekolah. Sebanyak 8 titik stopkontak baru telah selesai dipasang di selasar Gedung B.',
            'is_publik'      => 1,
        ]);

        Aspirasi::create([
            'judul'          => 'Penyediaan dispenser air minum galon tambahan di koridor lantai 3',
            'isi'            => 'Untuk mendukung program wajib membawa tumbler dan anti sampah botol plastik, kami memohon agar dispenser air minum di lantai 3 ditambah agar tidak antre panjang saat istirahat.',
            'nama_pengirim'  => 'Perwakilan Rayon Ciawi',
            'email_pengirim' => 'rayonciawi@smkwikrama.sch.id',
            'role_pengirim'  => 'warga',
            'status'         => 'diproses',
            'tanggapan'      => 'Aspirasi telah masuk agenda pembahasan rapat pleno MPR triwulan dan telah diteruskan ke Sekbid 5 dan tim logistik.',
            'is_publik'      => 1,
        ]);

        Aspirasi::create([
            'judul'          => 'Optimalisasi bandwidth Wi-Fi di laboratorium praktikum RPL',
            'isi'            => 'Koneksi internet seringkali melambat ketika seluruh siswa satu angkatan melakukan git push dan composer install bersamaan di lab komputer.',
            'nama_pengirim'  => 'Anggota Kelas PPLG XI',
            'email_pengirim' => 'pplg11@smkwikrama.sch.id',
            'role_pengirim'  => 'warga',
            'status'         => 'menunggu',
            'tanggapan'      => null,
            'is_publik'      => 1,
        ]);

        // ─────────────────────────────────────────────────────────
        // 6. KAS & KEUANGAN OSIS
        // ─────────────────────────────────────────────────────────
        Keuangan::create([
            'kegiatan_id'    => 0,
            'judul_kegiatan' => 'Sponsorship Mitra Industri untuk Dies Natalis',
            'jenis'          => 'pemasukan',
            'kategori'       => 'Sponsorship',
            'jumlah'         => 5000000,
            'keterangan'     => 'Dana kemitraan dan sponsorship kegiatan dari PT Solusi Digital.',
            'bukti_foto'     => null,
            'dicatat_oleh'   => 'Zahra Amelia (Bendahara Umum)',
        ]);

        Keuangan::create([
            'kegiatan_id'    => 0,
            'judul_kegiatan' => 'Iuran Kas Bulanan Pengurus OSIS & MPR Periode September',
            'jenis'          => 'pemasukan',
            'kategori'       => 'Iuran Kas',
            'jumlah'         => 1200000,
            'keterangan'     => 'Terkumpul dari 40 pengurus aktif OSIS-MPR.',
            'bukti_foto'     => null,
            'dicatat_oleh'   => 'Zahra Amelia (Bendahara Umum)',
        ]);

        Keuangan::create([
            'kegiatan_id'    => 1,
            'judul_kegiatan' => 'Pengadaan Rompi & Name Tag Petugas Piket GDS',
            'jenis'          => 'pengeluaran',
            'kategori'       => 'Perlengkapan',
            'jumlah'         => 850000,
            'keterangan'     => 'Pembelian 10 set rompi reflektif dan id card untuk tim ketertiban gerbang.',
            'bukti_foto'     => null,
            'dicatat_oleh'   => 'Zahra Amelia (Bendahara Umum)',
        ]);

        Keuangan::create([
            'kegiatan_id'    => 3,
            'judul_kegiatan' => 'Konsumsi Rapat Pleno Aspirasi Rayon MPR',
            'jenis'          => 'pengeluaran',
            'kategori'       => 'Konsumsi',
            'jumlah'         => 350000,
            'keterangan'     => 'Konsumsi makan siang dan snack misting untuk 35 perwakilan rayon.',
            'bukti_foto'     => null,
            'dicatat_oleh'   => 'Nabila Putri (Bendahara 1)',
        ]);

        // ─────────────────────────────────────────────────────────
        // 7. ABSENSI GDS — Data Rekap (berdasarkan format XLSX nyata)
        // Kolom: tanggal, hari, nama_anggota, divisi, jobdesk, penempatan,
        //        status_kehadiran, poin_pelanggaran, catatan, dicatat_oleh
        // ─────────────────────────────────────────────────────────
        $absensiData = [
            // Rekap GDS tanggal lalu dengan beberapa ketidakhadiran
            ['nama' => 'Muhamad Fahri Yansyah',      'divisi' => 'DH',       'jobdesk' => 'SIM',                        'penempatan' => 'Parkiran', 'status' => 'hadir',       'poin' => 0],
            ['nama' => 'Kiran Nanda Malika Putri',    'divisi' => 'MPR',      'jobdesk' => 'Pengawas & Pencatat Atribut', 'penempatan' => 'Belakang', 'status' => 'hadir',       'poin' => 0],
            ['nama' => 'Arya Bima',                   'divisi' => 'SEKBID 1', 'jobdesk' => 'Tas',                        'penempatan' => 'Belakang', 'status' => 'tidak_hadir', 'poin' => 3],
            ['nama' => 'Naufal Abdilah',              'divisi' => 'SEKBID 4', 'jobdesk' => 'Atribut Pria',               'penempatan' => 'Belakang', 'status' => 'hadir',       'poin' => 0],
            ['nama' => 'Chinesya Anggia',             'divisi' => 'SEKBID 2', 'jobdesk' => 'Atribut Wanita',             'penempatan' => 'Belakang', 'status' => 'terlambat',   'poin' => 3],
            ['nama' => 'Hilman Nazhir Fikriyana',     'divisi' => 'MPR',      'jobdesk' => 'Tas',                        'penempatan' => 'Belakang', 'status' => 'tidak_hadir', 'poin' => 3],
            ['nama' => 'Linda Februani',              'divisi' => 'DH',       'jobdesk' => 'Pengawas & Pencatat Tas',    'penempatan' => 'Belakang', 'status' => 'hadir',       'poin' => 0],
            ['nama' => 'Balqish Adara',               'divisi' => 'SEKBID 2', 'jobdesk' => 'Tas',                        'penempatan' => 'Belakang', 'status' => 'tidak_hadir', 'poin' => 3],
            ['nama' => 'Faiz Alin Nuha',              'divisi' => 'SEKBID 3', 'jobdesk' => 'Tas',                        'penempatan' => 'Belakang', 'status' => 'terlambat',   'poin' => 3],
            ['nama' => 'Khalista Naraya Suci',        'divisi' => 'SEKBID 1', 'jobdesk' => 'Atribut Wanita',             'penempatan' => 'Belakang', 'status' => 'tidak_hadir', 'poin' => 3],
            ['nama' => 'Shafa Azzahra Nurprayogo',    'divisi' => 'SEKBID 4', 'jobdesk' => 'Tas',                        'penempatan' => 'Belakang', 'status' => 'hadir',       'poin' => 0],
            ['nama' => 'Muhammad Gerrard Habibie',    'divisi' => 'SEKBID 5', 'jobdesk' => 'Tas',                        'penempatan' => 'Belakang', 'status' => 'terlambat',   'poin' => 3],
        ];

        $pastGdsDate = $now->copy()->subDays(3)->toDateString();
        $pastGdsHari = $now->copy()->subDays(3)->isoFormat('dddd');

        foreach ($absensiData as $a) {
            AbsensiGds::create([
                'tanggal'          => $pastGdsDate,
                'hari'             => $pastGdsHari,
                'nama_anggota'     => $a['nama'],
                'divisi'           => $a['divisi'],
                'jobdesk'          => $a['jobdesk'],
                'penempatan'       => $a['penempatan'],
                'status_kehadiran' => $a['status'],
                'poin_pelanggaran' => $a['poin'],
                'catatan'          => $a['poin'] > 0 ? 'Tidak konfirmasi sebelumnya.' : null,
                'dicatat_oleh'     => 'Fathan Al-Ghifari',
            ]);
        }

        // Tambah absensi hari ini (beberapa saja)
        AbsensiGds::create([
            'tanggal'          => $todayStr,
            'hari'             => $now->isoFormat('dddd'),
            'nama_anggota'     => 'Kiran Nanda Malika Putri',
            'divisi'           => 'MPR',
            'jobdesk'          => 'SIM',
            'penempatan'       => 'Parkiran',
            'status_kehadiran' => 'hadir',
            'poin_pelanggaran' => 0,
            'catatan'          => null,
            'dicatat_oleh'     => 'Fathan Al-Ghifari',
        ]);

        AbsensiGds::create([
            'tanggal'          => $todayStr,
            'hari'             => $now->isoFormat('dddd'),
            'nama_anggota'     => 'Naufal Abdilah',
            'divisi'           => 'SEKBID 4',
            'jobdesk'          => 'Pengawas & Pencatat Atribut',
            'penempatan'       => 'Belakang',
            'status_kehadiran' => 'hadir',
            'poin_pelanggaran' => 0,
            'catatan'          => null,
            'dicatat_oleh'     => 'Fathan Al-Ghifari',
        ]);

        // ─────────────────────────────────────────────────────────
        // 8. PELANGGARAN GDS — Contoh Data Digital (menggantikan catatan tangan)
        // ─────────────────────────────────────────────────────────
        $pelanggaranData = [
            [
                'nama_siswa'          => 'Ahmad Fauzi',
                'kelas'               => 'X RPL 1',
                'jurusan'             => 'RPL',
                'jenis_pelanggaran'   => 'Terlambat Masuk',
                'keterangan_tambahan' => 'Terlambat 15 menit, dari arah Ciawi.',
                'tingkat_keparahan'   => 'ringan',
                'dicatat_oleh'        => 'Kiran Nanda Malika Putri',
                'jabatan_pencatat'    => 'MPR',
                'jam'                 => '07:32:00',
            ],
            [
                'nama_siswa'          => 'Rizky Pratama',
                'kelas'               => 'XI TKJ 2',
                'jurusan'             => 'TKJ',
                'jenis_pelanggaran'   => 'Atribut Tidak Lengkap',
                'keterangan_tambahan' => 'Tidak memakai dasi dan topi.',
                'tingkat_keparahan'   => 'sedang',
                'dicatat_oleh'        => 'Naufal Abdilah',
                'jabatan_pencatat'    => 'Koordinator Bidang 4',
                'jam'                 => '07:15:00',
            ],
            [
                'nama_siswa'          => 'Siti Nurhaliza',
                'kelas'               => 'X DKV 1',
                'jurusan'             => 'DKV',
                'jenis_pelanggaran'   => 'Tidak Membawa Tumbler',
                'keterangan_tambahan' => null,
                'tingkat_keparahan'   => 'ringan',
                'dicatat_oleh'        => 'Rafka Athaya Khiry',
                'jabatan_pencatat'    => 'Koordinator Bidang 6',
                'jam'                 => '07:20:00',
            ],
            [
                'nama_siswa'          => 'Budi Santoso',
                'kelas'               => 'XII BDP 1',
                'jurusan'             => 'BDP',
                'jenis_pelanggaran'   => 'Rambut Tidak Rapi',
                'keterangan_tambahan' => 'Rambut panjang melewati kerah baju.',
                'tingkat_keparahan'   => 'ringan',
                'dicatat_oleh'        => 'Kiran Nanda Malika Putri',
                'jabatan_pencatat'    => 'MPR',
                'jam'                 => '07:10:00',
            ],
            [
                'nama_siswa'          => 'Dewi Rahayu',
                'kelas'               => 'XI Akuntansi 1',
                'jurusan'             => 'Akuntansi',
                'jenis_pelanggaran'   => 'Sepatu Tidak Sesuai',
                'keterangan_tambahan' => 'Menggunakan sepatu olahraga berwarna.',
                'tingkat_keparahan'   => 'sedang',
                'dicatat_oleh'        => 'Naufal Abdilah',
                'jabatan_pencatat'    => 'Koordinator Bidang 4',
                'jam'                 => '07:25:00',
            ],
        ];

        foreach ($pelanggaranData as $p) {
            PelanggaranGds::create([
                'tanggal'             => $pastGdsDate,
                'jam'                 => $p['jam'],
                'nama_siswa'          => $p['nama_siswa'],
                'kelas'               => $p['kelas'],
                'jurusan'             => $p['jurusan'],
                'jenis_pelanggaran'   => $p['jenis_pelanggaran'],
                'keterangan_tambahan' => $p['keterangan_tambahan'],
                'tingkat_keparahan'   => $p['tingkat_keparahan'],
                'dicatat_oleh'        => $p['dicatat_oleh'],
                'jabatan_pencatat'    => $p['jabatan_pencatat'],
            ]);
        }

        // Pelanggaran hari ini (contoh)
        PelanggaranGds::create([
            'tanggal'             => $todayStr,
            'jam'                 => '07:18:00',
            'nama_siswa'          => 'Fajar Maulana',
            'kelas'               => 'X RPL 2',
            'jurusan'             => 'RPL',
            'jenis_pelanggaran'   => 'Tidak Membawa Tumbler',
            'keterangan_tambahan' => null,
            'tingkat_keparahan'   => 'ringan',
            'dicatat_oleh'        => 'Kiran Nanda Malika Putri',
            'jabatan_pencatat'    => 'MPR',
        ]);
    }
}
