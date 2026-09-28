<?php
namespace App\Http\Controllers;
use App\Models\PiketGds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PiketController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $piket_hari_ini = PiketGds::where('tanggal', $today->toDateString())->get();
        $piket_minggu   = PiketGds::whereBetween('tanggal', [
            $today->copy()->startOfWeek()->toDateString(),
            $today->copy()->endOfWeek()->toDateString(),
        ])->orderBy('tanggal')->get();
        
        $jadwal = $piket_minggu;
        $jadwal_grouped = $piket_minggu->groupBy('tanggal');
        
        return view('piket.index', compact('piket_hari_ini', 'piket_minggu', 'jadwal', 'jadwal_grouped', 'today'));
    }

    public function upload(Request $request)
    {
        // Only pembina, dewan_penasihat, dewan_harian can upload
        $allowedRoles = ['pembina','dewan_penasihat','dewan_harian'];
        if (!in_array(Auth::user()->role, $allowedRoles)) abort(403);

        $request->validate(['csv_file' => 'required|file|mimes:csv,txt']);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));
        $header = array_shift($data); // remove header row
        
        $imported = 0;
        foreach ($data as $row) {
            if (count($row) < 3) continue;
            try {
                PiketGds::create([
                    'tanggal'         => Carbon::parse(trim($row[0]))->toDateString(),
                    'hari'            => trim($row[1] ?? 'Senin'),
                    'nama_petugas'    => trim($row[2]),
                    'jabatan_petugas' => trim($row[3] ?? 'Petugas GDS'),
                    'bidang_petugas'  => isset($row[4]) ? (int)$row[4] : 0,
                    'shift'           => trim($row[5] ?? 'Pagi'),
                ]);
                $imported++;
            } catch (\Exception $e) {
                continue;
            }
        }

        return back()->with('success', "Berhasil mengimpor $imported jadwal piket GDS.");
    }

    public function mySchedule()
    {
        // Show current user's own piket schedule
        $username = Auth::user()->name;
        $piket = PiketGds::where('nama_petugas', 'LIKE', '%' . $username . '%')
            ->where('tanggal', '>=', Carbon::today()->toDateString())
            ->orderBy('tanggal')
            ->take(30)
            ->get();

        return view('piket.my-schedule', compact('piket'));
    }
}
