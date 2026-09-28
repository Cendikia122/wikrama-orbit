<?php
namespace App\Http\Controllers;
use App\Models\Keuangan;
use App\Models\KegiatanOsis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{
    private function checkAccess() {
        $allowed = ['pembina','dewan_penasihat','dewan_harian'];
        if (!in_array(Auth::user()->role, $allowed)) abort(403, 'Akses keuangan hanya untuk Dewan Harian.');
    }

    public function index()
    {
        $this->checkAccess();
        $records      = Keuangan::orderBy('created_at','desc')->paginate(20);
        $total_masuk  = Keuangan::where('jenis','pemasukan')->sum('jumlah');
        $total_keluar = Keuangan::where('jenis','pengeluaran')->sum('jumlah');
        $saldo = $total_masuk - $total_keluar;
        return view('keuangan.index', compact('records','total_masuk','total_keluar','saldo'));
    }

    public function store(Request $request)
    {
        $this->checkAccess();
        $request->validate([
            'judul_kegiatan' => 'required',
            'jenis'          => 'required|in:pemasukan,pengeluaran',
            'kategori'       => 'required',
            'jumlah'         => 'required|integer|min:0',
            'keterangan'     => 'required|min:5',
            'bukti_foto'     => 'nullable|image|max:2048',
        ]);

        $foto = null;
        if ($request->hasFile('bukti_foto')) {
            $foto = $request->file('bukti_foto')->store('keuangan', 'public');
        }

        Keuangan::create([
            'kegiatan_id'    => $request->kegiatan_id ?? 0,
            'judul_kegiatan' => $request->judul_kegiatan,
            'jenis'          => $request->jenis,
            'kategori'       => $request->kategori,
            'jumlah'         => $request->jumlah,
            'keterangan'     => $request->keterangan,
            'bukti_foto'     => $foto,
            'dicatat_oleh'   => Auth::user()->name,
        ]);

        return redirect('/keuangan')->with('success', 'Transaksi berhasil dicatat!');
    }

    public function destroy($id)
    {
        $this->checkAccess();
        Keuangan::findOrFail($id)->delete();
        return redirect('/keuangan')->with('success', 'Data transaksi dihapus.');
    }
}
