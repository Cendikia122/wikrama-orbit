<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class OrganisasiController extends Controller
{
    public function index()
    {
        // Get all organisasi members (not warga), aktif
        $pembina         = User::where('role','pembina')->where('is_aktif',1)->get();
        $dewan_penasihat = User::where('role','dewan_penasihat')->where('is_aktif',1)->get();
        $mpr             = User::where('role','mpr')->where('is_aktif',1)->get();
        $dewan_harian    = User::where('role','dewan_harian')->where('is_aktif',1)->get();
        $koordinator     = User::where('role','koordinator_bidang')->where('is_aktif',1)->orderBy('bidang')->get();
        
        // Archived members
        $arsip = User::where('is_aktif',0)->where('role','!=','warga')->get();
        
        return view('organisasi.index', compact(
            'pembina','dewan_penasihat','mpr','dewan_harian','koordinator','arsip'
        ));
    }

    public function sekbid($nomor)
    {
        $nomor = (int) $nomor;
        if ($nomor < 1 || $nomor > 10) abort(404);
        
        $sekbid_info = [
            1  => ['nama' => 'Keimanan & Ketakwaan', 'full' => 'Seksi Bidang Keimanan dan Ketakwaan terhadap Tuhan Yang Maha Esa', 'emoji' => '🕌', 'color' => 'green'],
            2  => ['nama' => 'Budi Pekerti & Akhlak', 'full' => 'Seksi Bidang Budi Pekerti Luhur atau Akhlak Mulia', 'emoji' => '✨', 'color' => 'yellow'],
            3  => ['nama' => 'Kepribadian & Bela Negara', 'full' => 'Seksi Bidang Kepribadian Unggul, Wawasan Kebangsaan, dan Bela Negara', 'emoji' => '🇮🇩', 'color' => 'red'],
            4  => ['nama' => 'Prestasi & Olahraga', 'full' => 'Seksi Bidang Prestasi Akademik, Seni, dan/atau Olahraga sesuai Bakat dan Minat', 'emoji' => '🏆', 'color' => 'purple'],
            5  => ['nama' => 'Demokrasi & Lingkungan Hidup', 'full' => 'Seksi Bidang Demokrasi, HAM, Pendidikan Politik, Lingkungan Hidup, dan Toleransi Sosial', 'emoji' => '🌿', 'color' => 'emerald'],
            6  => ['nama' => 'Kreativitas & Kewirausahaan', 'full' => 'Seksi Bidang Kreativitas, Keterampilan dan Kewirausahaan', 'emoji' => '💡', 'color' => 'orange'],
            7  => ['nama' => 'Kesehatan & Gizi', 'full' => 'Seksi Bidang Kualitas Jasmani, Kesehatan, dan Gizi Berbasis Sumber Gizi yang Terdiversifikasi', 'emoji' => '🥗', 'color' => 'teal'],
            8  => ['nama' => 'Sastra & Budaya', 'full' => 'Seksi Bidang Sastra dan Budaya', 'emoji' => '🎭', 'color' => 'pink'],
            9  => ['nama' => 'Teknologi Informasi & Komunikasi', 'full' => 'Seksi Bidang Teknologi Informasi dan Komunikasi (TIK)', 'emoji' => '💻', 'color' => 'blue'],
            10 => ['nama' => 'Komunikasi Bahasa Inggris', 'full' => 'Seksi Bidang Komunikasi dalam Bahasa Inggris', 'emoji' => '🌐', 'color' => 'indigo'],
        ];
        
        $info        = $sekbid_info[$nomor];
        $koordinator = User::where('role','koordinator_bidang')->where('bidang',$nomor)->where('is_aktif',1)->first();
        
        // Get kegiatan for this bidang (flat query, NO join)
        $kegiatan = \App\Models\KegiatanOsis::where('bidang_pic', $nomor)->orderBy('created_at','desc')->take(10)->get();
        
        return view('organisasi.sekbid', compact('nomor','info','koordinator','kegiatan'));
    }
}
