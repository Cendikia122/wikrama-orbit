<?php
namespace App\Http\Controllers;
use App\Models\PelanggaranGds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PelanggaranGdsController extends Controller
{
    private $jenisPelanggaran = [
        'Atribut Tidak Lengkap',
        'Terlambat Masuk',
        'Tidak Membawa Tumbler',
        'Tidak Memakai Sabuk',
        'Rambut Tidak Rapi',
        'Seragam Tidak Sesuai',
        'Sepatu Tidak Sesuai',
        'Membawa Barang Terlarang',
        'HP di Sekolah (melanggar aturan)',
        'Lain-lain',
    ];

    private function checkAccess() {
        $allowed = ['pembina','dewan_penasihat','mpr','dewan_harian','koordinator_bidang'];
        if (!Auth::check() || !in_array(Auth::user()->role, $allowed)) abort(403);
    }

    public function index()
    {
        $this->checkAccess();
        $filter_tanggal = request('filter_tanggal', request('tanggal', Carbon::today()->toDateString()));
        $pelanggaran = PelanggaranGds::where('tanggal', $filter_tanggal)
            ->orderBy('jam', 'desc')
            ->get();

        // MySQL safe: distinct tanggal without conflicting order by
        $all_dates = PelanggaranGds::distinct()
            ->orderBy('tanggal', 'desc')
            ->limit(30)
            ->pluck('tanggal');

        $pelanggaran_hari_ini = PelanggaranGds::where('tanggal', Carbon::today()->toDateString())->count();
        $jenis_list = $this->jenisPelanggaran;

        return view('piket.pelanggaran', compact('pelanggaran', 'filter_tanggal', 'all_dates', 'jenis_list', 'pelanggaran_hari_ini'));
    }

    public function store(Request $request)
    {
        $this->checkAccess();
        $request->validate([
            'nama_siswa'          => 'required|string|min:2',
            'kelas'               => 'required|string',
            'jurusan'             => 'nullable|string',
            'jenis_pelanggaran'   => 'required|string',
            'keterangan_tambahan' => 'nullable|string',
            'tingkat_keparahan'   => 'required|in:ringan,sedang,berat,Ringan,Sedang,Berat',
        ]);

        PelanggaranGds::create([
            'tanggal'             => Carbon::today()->toDateString(),
            'jam'                 => Carbon::now()->format('H:i:s'),
            'nama_siswa'          => $request->nama_siswa,
            'kelas'               => $request->kelas,
            'jurusan'             => $request->jurusan,
            'jenis_pelanggaran'   => $request->jenis_pelanggaran,
            'keterangan_tambahan' => $request->keterangan_tambahan,
            'tingkat_keparahan'   => strtolower($request->tingkat_keparahan),
            'dicatat_oleh'        => Auth::user()->name,
            'jabatan_pencatat'    => Auth::user()->jabatan,
        ]);

        return back()->with('success', 'Pelanggaran berhasil dicatat!');
    }

    public function destroy($id)
    {
        $this->checkAccess();
        PelanggaranGds::findOrFail($id)->delete();
        return back()->with('success', 'Data pelanggaran dihapus.');
    }
}
