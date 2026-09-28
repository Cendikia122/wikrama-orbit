<?php

namespace App\Http\Controllers;

use App\Models\KegiatanOsis;
use App\Models\PiketGds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KegiatanController extends Controller
{
    // ─────────────────────────────────────────────── INDEX ────

    public function index(Request $request)
    {
        $user = Auth::user();

        // Non-pengurus (warga) directed to aspirasi
        if ($user->role === 'warga') {
            return redirect('/aspirasi')->with('info', 'Selamat datang! Sebagai Warga Wikrama, Anda dapat menyampaikan aspirasi ke MPR dan mengikuti Live Events.');
        }

        $tab = $request->query('tab', 'kanban'); // 'kanban', 'belum', 'selesai'
        $bidangFilter = $request->query('bidang', 'all');

        $query = KegiatanOsis::query();

        if ($bidangFilter !== 'all' && is_numeric($bidangFilter)) {
            $query->where('bidang_pic', (int)$bidangFilter);
        }

        if ($tab === 'selesai') {
            $kegiatan = (clone $query)->where('status', 1)
                ->orderBy('done_time', 'desc')
                ->get();
        } elseif ($tab === 'belum') {
            $kegiatan = (clone $query)->where('status', 0)
                ->orderBy('target_selesai', 'asc')
                ->get();
        } else {
            // Kanban / All
            $kegiatan = (clone $query)->orderBy('target_selesai', 'asc')->get();
        }

        // Kanban columns
        $kanbanTodo       = (clone $query)->where('kanban_status', 'todo')->orderBy('target_selesai', 'asc')->get();
        $kanbanInProgress = (clone $query)->where('kanban_status', 'inprogress')->orderBy('target_selesai', 'asc')->get();
        $kanbanBlocked    = (clone $query)->where('kanban_status', 'blocked')->orderBy('target_selesai', 'asc')->get();
        $kanbanDone       = (clone $query)->where(function($q) {
            $q->where('kanban_status', 'done')->orWhere('status', 1);
        })->orderBy('done_time', 'desc')->get();

        $total          = KegiatanOsis::count();
        $belum_selesai  = KegiatanOsis::where('status', 0)->count();
        $selesai        = KegiatanOsis::where('status', 1)->count();
        $overdue        = KegiatanOsis::where('status', 0)
                            ->where('target_selesai', '<', Carbon::now())
                            ->count();

        // User's own upcoming GDS piket (highlighted boldly)
        $myNextPiket = PiketGds::where('nama_petugas', 'LIKE', '%' . $user->name . '%')
            ->where('tanggal', '>=', Carbon::today()->toDateString())
            ->orderBy('tanggal')
            ->first();

        return view('dashboard.index', compact(
            'kegiatan', 'tab', 'bidangFilter', 'total', 'belum_selesai', 'selesai', 'overdue',
            'kanbanTodo', 'kanbanInProgress', 'kanbanBlocked', 'kanbanDone', 'myNextPiket'
        ));
    }

    // ──────────────────────────────────────────────── STORE ───

    public function store(Request $request)
    {
        $request->validate([
            'title'                 => 'required|min:4',
            'penanggung_jawab'      => 'required',
            'kategori'              => 'required',
            'target_selesai'        => 'required|date',
            'catatan_evaluasi'      => 'required|min:15',
            'kanban_status'         => 'nullable|in:todo,inprogress,blocked,done',
            'prioritas'             => 'nullable|in:rendah,normal,tinggi,kritis',
            'bidang_pic'            => 'nullable|integer',
            'persentase_selesai'    => 'nullable|integer|min:0|max:100',
            'nama_ketua_pelaksana'  => 'nullable|string',
        ]);

        $kanbanStatus = $request->kanban_status ?? 'todo';
        $isDone = ($kanbanStatus === 'done');

        KegiatanOsis::create([
            'title'                => $request->title,
            'penanggung_jawab'     => $request->penanggung_jawab,
            'kategori'             => $request->kategori,
            'target_selesai'       => $request->target_selesai,
            'status'               => $isDone ? 1 : 0,
            'done_time'            => $isDone ? Carbon::now() : null,
            'catatan_evaluasi'     => $request->catatan_evaluasi,
            'kanban_status'        => $kanbanStatus,
            'prioritas'            => $request->prioritas ?? 'normal',
            'bidang_pic'           => $request->bidang_pic ?? 0,
            'persentase_selesai'   => $request->persentase_selesai ?? ($isDone ? 100 : 0),
            'nama_ketua_pelaksana' => $request->nama_ketua_pelaksana,
        ]);

        return redirect('/dashboard')->with('success', 'Kegiatan / Proker berhasil ditambahkan!');
    }

    // ───────────────────────────────────────────────── EDIT ───

    public function edit($id)
    {
        $kegiatan = KegiatanOsis::findOrFail($id);
        return view('dashboard.edit', compact('kegiatan'));
    }

    // ─────────────────────────────────────────────── UPDATE ───

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'                 => 'required|min:4',
            'penanggung_jawab'      => 'required',
            'kategori'              => 'required',
            'target_selesai'        => 'required|date',
            'catatan_evaluasi'      => 'required|min:15',
            'kanban_status'         => 'nullable|in:todo,inprogress,blocked,done',
            'prioritas'             => 'nullable|in:rendah,normal,tinggi,kritis',
            'bidang_pic'            => 'nullable|integer',
            'persentase_selesai'    => 'nullable|integer|min:0|max:100',
            'nama_ketua_pelaksana'  => 'nullable|string',
        ]);

        $kegiatan = KegiatanOsis::findOrFail($id);
        $kanbanStatus = $request->kanban_status ?? $kegiatan->kanban_status ?? 'todo';
        $isDone = ($kanbanStatus === 'done');

        $kegiatan->update([
            'title'                => $request->title,
            'penanggung_jawab'     => $request->penanggung_jawab,
            'kategori'             => $request->kategori,
            'target_selesai'       => $request->target_selesai,
            'catatan_evaluasi'     => $request->catatan_evaluasi,
            'kanban_status'        => $kanbanStatus,
            'prioritas'            => $request->prioritas ?? $kegiatan->prioritas ?? 'normal',
            'bidang_pic'           => $request->bidang_pic ?? $kegiatan->bidang_pic ?? 0,
            'persentase_selesai'   => $request->persentase_selesai ?? $kegiatan->persentase_selesai ?? 0,
            'nama_ketua_pelaksana' => $request->nama_ketua_pelaksana ?? $kegiatan->nama_ketua_pelaksana,
            'status'               => $isDone ? 1 : 0,
            'done_time'            => $isDone ? ($kegiatan->done_time ?? Carbon::now()) : null,
        ]);

        return redirect('/dashboard')->with('success', 'Data kegiatan berhasil diperbarui!');
    }

    // ─────────────────────────────────────────── KANBAN QUICK UPDATE ─

    public function updateKanban(Request $request, $id)
    {
        $request->validate([
            'kanban_status'      => 'required|in:todo,inprogress,blocked,done',
            'persentase_selesai' => 'nullable|integer|min:0|max:100',
        ]);

        $kegiatan = KegiatanOsis::findOrFail($id);
        $isDone = ($request->kanban_status === 'done');

        $data = [
            'kanban_status' => $request->kanban_status,
            'status'        => $isDone ? 1 : 0,
            'done_time'     => $isDone ? Carbon::now() : null,
        ];

        if ($request->filled('persentase_selesai')) {
            $data['persentase_selesai'] = (int)$request->persentase_selesai;
        } elseif ($isDone) {
            $data['persentase_selesai'] = 100;
        }

        $kegiatan->update($data);

        return back()->with('success', "Progress proker '{$kegiatan->title}' berhasil diperbarui!");
    }

    // ─────────────────────────────────────────── TOGGLE STATUS ─

    public function toggleStatus($id)
    {
        $kegiatan = KegiatanOsis::findOrFail($id);

        if ($kegiatan->status == 0) {
            $kegiatan->status             = 1;
            $kegiatan->kanban_status      = 'done';
            $kegiatan->persentase_selesai = 100;
            $kegiatan->done_time          = Carbon::now();
            $kegiatan->save();
            return back()->with('success', 'Kegiatan berhasil ditandai selesai!');
        } else {
            $kegiatan->status             = 0;
            $kegiatan->kanban_status      = 'inprogress';
            $kegiatan->done_time          = null;
            $kegiatan->save();
            return back()->with('success', 'Kegiatan berhasil dikembalikan ke Belum Selesai.');
        }
    }

    // ─────────────────────────────────────────────── DESTROY ──

    public function destroy($id)
    {
        KegiatanOsis::findOrFail($id)->delete();
        return redirect('/dashboard')->with('success', 'Data kegiatan berhasil dihapus!');
    }
}
