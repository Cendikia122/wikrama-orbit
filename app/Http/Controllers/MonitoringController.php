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

    public function downloadTemplate()
    {
        $this->checkManage();
        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="template_anggota_orbit.csv"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            // UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['nama', 'username', 'email', 'role', 'jabatan', 'bidang', 'angkatan', 'periode']);
            fputcsv($file, ['Ahmad Fauzan', 'ahmadf', 'ahmad@smkwikrama.sch.id', 'dewan_harian', 'Sekretaris 2', '0', '2025/2026', '2025/2026']);
            fputcsv($file, ['Siti Nurhaliza', 'sitinur', 'siti@smkwikrama.sch.id', 'koordinator_bidang', 'Koordinator Bidang 1', '1', '2025/2026', '2025/2026']);
            fputcsv($file, ['Budi Santoso', 'budis', 'budi@smkwikrama.sch.id', 'mpr', 'Anggota MPR', '0', '2025/2026', '2025/2026']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importCsv(Request $request)
    {
        $this->checkManage();
        $request->validate([
            'csv_file' => 'required|file|max:5120',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $ext  = strtolower($file->getClientOriginalExtension());

        $rows = [];
        if ($ext === 'xlsx') {
            $rows = $this->parseXlsx($path);
        } else {
            // Read CSV (support semicolon or comma delimiter)
            $fileHandle = fopen($path, 'r');
            $firstLine  = fgets($fileHandle);
            fclose($fileHandle);
            $delimiter  = (strpos($firstLine, ';') !== false && strpos($firstLine, ',') === false) ? ';' : ',';

            $handle = fopen($path, 'r');
            while (($r = fgetcsv($handle, 1000, $delimiter)) !== false) {
                $rows[] = $r;
            }
            fclose($handle);
        }

        if (empty($rows)) {
            return back()->with('error', 'File kosong atau tidak dapat dibaca.');
        }

        // Find header row (search first 10 rows for "nama" or "name")
        $headerRowIdx = -1;
        $nameColIdx   = -1;
        $roleColIdx   = -1;
        $jabatanColIdx= -1;
        $usernameColIdx = -1;
        $emailColIdx  = -1;
        $bidangColIdx = -1;

        foreach ($rows as $rIdx => $row) {
            if (!is_array($row)) continue;
            foreach ($row as $cIdx => $cell) {
                $c = strtolower(trim((string)$cell));
                if ($c === 'nama' || $c === 'name' || str_contains($c, 'nama lengkap')) {
                    $headerRowIdx = $rIdx;
                    break 2;
                }
            }
        }

        // Fallback: row 0 is header
        if ($headerRowIdx === -1) {
            $headerRowIdx = 0;
        }

        // Map column indices from header row
        foreach ($rows[$headerRowIdx] as $cIdx => $cell) {
            $c = strtolower(trim(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', (string)$cell)));
            if (str_contains($c, 'nama') || $c === 'name') $nameColIdx = $cIdx;
            elseif ($c === 'sekbid' || $c === 'divisi' || $c === 'role') $roleColIdx = $cIdx;
            elseif (str_contains($c, 'jabatan') || str_contains($c, 'jobdesk') || $c === 'rayon') $jabatanColIdx = $cIdx;
            elseif ($c === 'username') $usernameColIdx = $cIdx;
            elseif ($c === 'email') $emailColIdx = $cIdx;
            elseif ($c === 'bidang') $bidangColIdx = $cIdx;
        }

        if ($nameColIdx === -1) {
            $nameColIdx = 1; // default: column 1 (after No)
        }

        $imported = 0;
        $skipped  = 0;

        for ($i = $headerRowIdx + 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            if (!is_array($row) || empty(array_filter($row))) continue;

            $name = isset($row[$nameColIdx]) ? trim((string)$row[$nameColIdx]) : '';
            if (!$name || strtolower($name) === 'nama' || strtolower($name) === 'no' || is_numeric($name)) continue;

            $rawRole = $roleColIdx >= 0 && isset($row[$roleColIdx]) ? strtolower(trim((string)$row[$roleColIdx])) : '';
            $jabatan = $jabatanColIdx >= 0 && isset($row[$jabatanColIdx]) ? trim((string)$row[$jabatanColIdx]) : 'Anggota';
            $rawUsername = $usernameColIdx >= 0 && isset($row[$usernameColIdx]) ? trim((string)$row[$usernameColIdx]) : '';
            $rawEmail = $emailColIdx >= 0 && isset($row[$emailColIdx]) ? trim((string)$row[$emailColIdx]) : '';
            $bidang = $bidangColIdx >= 0 && isset($row[$bidangColIdx]) ? (int)$row[$bidangColIdx] : 0;

            // Determine role & sekbid number
            $role = 'dewan_harian';
            if (str_contains($rawRole, 'pembina')) {
                $role = 'pembina';
                if ($jabatan === 'Anggota') $jabatan = 'Pembina OSIS';
            } elseif (str_contains($rawRole, 'penasihat') || $rawRole === 'dp') {
                $role = 'dewan_penasihat';
                if ($jabatan === 'Anggota') $jabatan = 'Dewan Penasihat';
            } elseif (str_contains($rawRole, 'mpr')) {
                $role = 'mpr';
                if ($jabatan === 'Anggota') $jabatan = 'Anggota MPR';
            } elseif (str_contains($rawRole, 'sekbid') || str_contains($rawRole, 'koorbid') || str_contains($rawRole, 'koordinator')) {
                $role = 'koordinator_bidang';
                if (preg_match('/(\d+)/', $rawRole, $m)) {
                    $bidang = (int)$m[1];
                }
                if ($jabatan === 'Anggota') $jabatan = 'Seksi Bidang ' . ($bidang ?: '');
            } elseif (str_contains($rawRole, 'dh') || str_contains($rawRole, 'harian')) {
                $role = 'dewan_harian';
                if ($jabatan === 'Anggota') $jabatan = 'Dewan Harian';
            }

            // Generate clean username (safe for DB, max 20 chars)
            $username = $rawUsername;
            if (!$username) {
                $cleanName = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', explode(' ', $name)[0]));
                $username = substr($cleanName, 0, 14) . rand(10, 99);
            } else {
                $username = substr(strtolower(preg_replace('/[^a-zA-Z0-9_-]/', '', $username)), 0, 20);
            }

            // Generate email
            $email = $rawEmail;
            if (!$email) {
                $email = $username . '@smkwikrama.sch.id';
            } elseif (!str_ends_with($email, '@smkwikrama.sch.id')) {
                $email = explode('@', $email)[0] . '@smkwikrama.sch.id';
            }

            // Skip duplicate
            if (User::where('username', $username)->orWhere('email', $email)->exists()) {
                $skipped++;
                continue;
            }

            User::create([
                'name'      => $name,
                'username'  => $username,
                'email'     => $email,
                'password'  => Hash::make('wikrama2025'),
                'role'      => $role,
                'jabatan'   => $jabatan,
                'bidang'    => $bidang,
                'angkatan'  => '2025/2026',
                'periode'   => '2025/2026',
                'is_aktif'  => 1,
            ]);

            $imported++;
        }

        $msg = "Berhasil mengimpor $imported anggota baru.";
        if ($skipped > 0) {
            $msg .= " ($skipped anggota dilewati karena username/email sudah terdaftar).";
        }

        return redirect()->route('monitoring.index')->with('success', $msg);
    }

    /**
     * Pure PHP parser for XLSX files without external composer packages.
     */
    private function parseXlsx(string $path): array
    {
        $zip = new \ZipArchive();
        if ($zip->open($path) !== true) return [];

        // 1. Read shared strings
        $strings = [];
        if (($idx = $zip->locateName('xl/sharedStrings.xml')) !== false) {
            $xml = @simplexml_load_string($zip->getFromIndex($idx));
            if ($xml && isset($xml->si)) {
                foreach ($xml->si as $val) {
                    if (isset($val->t)) {
                        $strings[] = (string)$val->t;
                    } elseif (isset($val->r)) {
                        $t = '';
                        foreach ($val->r as $r) { $t .= (string)$r->t; }
                        $strings[] = $t;
                    } else {
                        $strings[] = '';
                    }
                }
            }
        }

        // 2. Read first worksheet
        $sheetXmlStr = $zip->getFromName('xl/worksheets/sheet1.xml');
        if (!$sheetXmlStr) {
            // Try locating any worksheet
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filename = $zip->getNameIndex($i);
                if (str_starts_with($filename, 'xl/worksheets/sheet') && str_ends_with($filename, '.xml')) {
                    $sheetXmlStr = $zip->getFromIndex($i);
                    break;
                }
            }
        }

        $rows = [];
        if ($sheetXmlStr) {
            $sheetXml = @simplexml_load_string($sheetXmlStr);
            if ($sheetXml && isset($sheetXml->sheetData->row)) {
                foreach ($sheetXml->sheetData->row as $r) {
                    $row = [];
                    foreach ($r->c as $c) {
                        $val = (string)$c->v;
                        if ((string)$c['t'] === 's') {
                            $val = $strings[(int)$val] ?? '';
                        }
                        $row[] = trim($val);
                    }
                    $rows[] = $row;
                }
            }
        }

        $zip->close();
        return $rows;
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

