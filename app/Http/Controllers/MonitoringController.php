<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\AbsensiGds;
use App\Models\PelanggaranGds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MonitoringController extends Controller
{
    private $manageRoles = ['pembina', 'dewan_penasihat', 'dewan_harian'];
    private $viewRoles   = ['pembina', 'dewan_penasihat', 'mpr', 'dewan_harian', 'koordinator_bidang'];

    private function checkView() {
        if (!Auth::check() || !in_array(Auth::user()->role, $this->viewRoles)) abort(403);
    }

    private function checkManage() {
        if (!Auth::check() || !in_array(Auth::user()->role, $this->manageRoles)) abort(403);
    }

    public function index(Request $request)
    {
        $this->checkView();

        $query = User::where('role', '!=', 'warga');

        if ($request->filled('role'))     $query->where('role', $request->role);
        if ($request->filled('bidang'))   $query->where('bidang', $request->bidang);
        if ($request->filled('is_aktif')) $query->where('is_aktif', $request->is_aktif);
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('jabatan', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('username', 'LIKE', '%'.$request->search.'%');
            });
        }

        $anggota = $query->orderByRaw("CASE role
            WHEN 'pembina' THEN 1
            WHEN 'dewan_penasihat' THEN 2
            WHEN 'mpr' THEN 3
            WHEN 'dewan_harian' THEN 4
            WHEN 'koordinator_bidang' THEN 5
            ELSE 6 END")->orderBy('bidang')->get();

        $total_anggota    = User::where('role', '!=', 'warga')->count();
        $total_aktif      = User::where('role', '!=', 'warga')->where('is_aktif', 1)->count();
        $total_absen_gds  = AbsensiGds::where('status_kehadiran', 'tidak_hadir')->count();
        $total_pelanggaran = PelanggaranGds::count();

        $canManage = in_array(Auth::user()->role, $this->manageRoles);

        return view('monitoring.index', compact(
            'anggota', 'total_anggota', 'total_aktif', 'total_absen_gds', 'total_pelanggaran', 'canManage'
        ));
    }

    public function create()
    {
        $this->checkManage();
        return view('monitoring.create');
    }

    public function store(Request $request)
    {
        $this->checkManage();

        $request->validate([
            'name'     => 'required|string|min:3|max:100',
            'username' => 'required|string|min:3|max:20|unique:users,username|alpha_dash',
            'email'    => ['required', 'email', 'unique:users,email', 'regex:/@smkwikrama\.sch\.id$/'],
            'role'     => 'required|in:pembina,dewan_penasihat,mpr,dewan_harian,koordinator_bidang',
            'jabatan'  => 'required|string|max:100',
            'bidang'   => 'nullable|integer|min:0|max:10',
            'angkatan' => 'nullable|string|max:20',
            'periode'  => 'nullable|string|max:20',
        ], [
            'email.regex'         => 'Email harus menggunakan domain @smkwikrama.sch.id',
            'username.alpha_dash' => 'Username hanya boleh huruf, angka, tanda hubung, dan underscore.',
            'username.unique'     => 'Username sudah dipakai.',
            'email.unique'        => 'Email sudah terdaftar.',
        ]);

        User::create([
            'name'      => $request->name,
            'username'  => $request->username,
            'email'     => $request->email,
            'password'  => Hash::make('wikrama2025'),
            'role'      => $request->role,
            'jabatan'   => $request->jabatan,
            'bidang'    => $request->bidang ?? 0,
            'angkatan'  => $request->angkatan,
            'periode'   => $request->periode,
            'is_aktif'  => 1,
        ]);

        return redirect()->route('monitoring.index')
            ->with('success', 'Anggota '.$request->name.' berhasil ditambahkan. Password default: wikrama2025');
    }

    public function edit($id)
    {
        $this->checkManage();
        $anggota = User::findOrFail($id);
        if ($anggota->role === 'warga') abort(404);
        return view('monitoring.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $this->checkManage();
        $anggota = User::findOrFail($id);
        if ($anggota->role === 'warga') abort(404);

        $request->validate([
            'name'     => 'required|string|min:3|max:100',
            'role'     => 'required|in:pembina,dewan_penasihat,mpr,dewan_harian,koordinator_bidang',
            'jabatan'  => 'required|string|max:100',
            'bidang'   => 'nullable|integer|min:0|max:10',
            'angkatan' => 'nullable|string|max:20',
            'periode'  => 'nullable|string|max:20',
        ]);

        $anggota->update([
            'name'     => $request->name,
            'role'     => $request->role,
            'jabatan'  => $request->jabatan,
            'bidang'   => $request->bidang ?? 0,
            'angkatan' => $request->angkatan,
            'periode'  => $request->periode,
        ]);

        return redirect()->route('monitoring.index')
            ->with('success', 'Data '.$anggota->name.' berhasil diperbarui.');
    }

    public function toggleAktif($id)
    {
        $this->checkManage();
        $anggota = User::findOrFail($id);
        if ($anggota->id === Auth::id()) {
            return back()->with('error', 'Tidak bisa menonaktifkan akun sendiri.');
        }
        $anggota->update(['is_aktif' => !$anggota->is_aktif]);
        $status = $anggota->is_aktif ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', 'Anggota '.$anggota->name.' berhasil '.$status.'.');
    }

    public function resetPassword($id)
    {
        $this->checkManage();
        $anggota = User::findOrFail($id);
        $anggota->update(['password' => Hash::make('wikrama2025')]);
        return back()->with('success', 'Password '.$anggota->name.' berhasil direset ke: wikrama2025');
    }

    public function destroy($id)
    {
        // Only pembina and dewan_penasihat can hard delete
        if (!in_array(Auth::user()->role, ['pembina', 'dewan_penasihat'])) abort(403);
        $anggota = User::findOrFail($id);
        if ($anggota->id === Auth::id()) return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        $name = $anggota->name;
        $anggota->delete();
        return back()->with('success', 'Anggota '.$name.' berhasil dihapus permanen.');
    }
}
