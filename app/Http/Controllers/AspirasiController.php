<?php
namespace App\Http\Controllers;
use App\Models\Aspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AspirasiController extends Controller
{
    // Public list page
    public function index()
    {
        $aspirasi = Aspirasi::where('is_publik', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('aspirasi.index', compact('aspirasi'));
    }

    // Submit form (authenticated warga or guest-like but we require login)
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|min:5|max:150',
            'isi'   => 'required|min:20',
        ]);

        Aspirasi::create([
            'judul'         => $request->judul,
            'isi'           => $request->isi,
            'nama_pengirim' => Auth::user()->name,
            'email_pengirim'=> Auth::user()->email,
            'role_pengirim' => Auth::user()->role,
            'status'        => 'menunggu',
            'is_publik'     => 1,
        ]);

        return redirect('/aspirasi')->with('success', 'Aspirasi berhasil disampaikan kepada MPR!');
    }

    // MPR-only: update status + tanggapan
    public function update(Request $request, $id)
    {
        // Only MPR, DH, Pembina can update
        $allowedRoles = ['pembina','dewan_penasihat','mpr','dewan_harian'];
        if (!in_array(Auth::user()->role, $allowedRoles)) {
            abort(403);
        }

        $request->validate([
            'status'    => 'required|in:menunggu,diproses,selesai',
            'tanggapan' => 'nullable|min:10',
        ]);

        $aspirasi = Aspirasi::findOrFail($id);
        $aspirasi->update([
            'status'    => $request->status,
            'tanggapan' => $request->tanggapan,
        ]);

        return redirect('/aspirasi')->with('success', 'Tanggapan berhasil disimpan.');
    }

    public function destroy($id)
    {
        $allowedRoles = ['pembina','mpr','dewan_harian'];
        if (!in_array(Auth::user()->role, $allowedRoles)) abort(403);
        Aspirasi::findOrFail($id)->delete();
        return redirect('/aspirasi')->with('success', 'Aspirasi dihapus.');
    }
}
