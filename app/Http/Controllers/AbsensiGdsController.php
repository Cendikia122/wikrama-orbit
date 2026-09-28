<?php
namespace App\Http\Controllers;
use App\Models\AbsensiGds;
use App\Models\PiketGds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiGdsController extends Controller
{
    private function checkAccess() {
        $allowed = ['pembina','dewan_penasihat','mpr','dewan_harian','koordinator_bidang'];
        if (!Auth::check() || !in_array(Auth::user()->role, $allowed)) abort(403);
    }

    public function index()
    {
        $this->checkAccess();
        $absensi = AbsensiGds::orderBy('tanggal', 'desc')->paginate(30);
        
        // Summary per anggota: count tidak_hadir
        $summary = AbsensiGds::selectRaw('nama_anggota, divisi, COUNT(*) as total_gds, SUM(CASE WHEN status_kehadiran = "tidak_hadir" THEN 1 ELSE 0 END) as total_absen, SUM(CASE WHEN status_kehadiran = "terlambat" THEN 1 ELSE 0 END) as total_terlambat, SUM(poin_pelanggaran) as total_poin')
            ->groupBy('nama_anggota', 'divisi')
            ->orderBy('total_absen', 'desc')
            ->get();

        return view('piket.absensi', compact('absensi', 'summary'));
    }

    public function store(Request $request)
    {
        $this->checkAccess();
        $request->validate([
            'tanggal'          => 'required|date',
            'hari'             => 'required|string',
            'nama_anggota'     => 'required|string',
            'divisi'           => 'required|string',
            'jobdesk'          => 'nullable|string',
            'penempatan'       => 'nullable|string',
            'status_kehadiran' => 'required|in:hadir,tidak_hadir,terlambat',
            'poin_pelanggaran' => 'nullable|integer|min:0',
            'catatan'          => 'nullable|string',
        ]);

        AbsensiGds::create([
            'tanggal'          => $request->tanggal,
            'hari'             => $request->hari,
            'nama_anggota'     => $request->nama_anggota,
            'divisi'           => $request->divisi,
            'jobdesk'          => $request->jobdesk,
            'penempatan'       => $request->penempatan,
            'status_kehadiran' => $request->status_kehadiran,
            'poin_pelanggaran' => $request->poin_pelanggaran ?? 0,
            'catatan'          => $request->catatan,
            'dicatat_oleh'     => Auth::user()->name,
        ]);

        return back()->with('success', 'Data absensi berhasil dicatat.');
    }

    public function destroy($id)
    {
        $this->checkAccess();
        AbsensiGds::findOrFail($id)->delete();
        return back()->with('success', 'Data absensi dihapus.');
    }
}
