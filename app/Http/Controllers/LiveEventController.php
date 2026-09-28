<?php
namespace App\Http\Controllers;
use App\Models\LiveEvent;
use App\Models\LiveEventOption;
use App\Models\LiveEventVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LiveEventController extends Controller
{
    public function index()
    {
        $events = LiveEvent::orderBy('created_at','desc')->get();
        return view('live-events.index', compact('events'));
    }

    public function show($id)
    {
        $event   = LiveEvent::findOrFail($id);
        $options = LiveEventOption::where('live_event_id', $id)->orderBy('jumlah_suara','desc')->get();
        $total_suara = $options->sum('jumlah_suara');
        
        $sudah_vote = false;
        if (Auth::check()) {
            $sudah_vote = LiveEventVote::where('live_event_id', $id)
                ->where('voter_username', Auth::user()->username)
                ->exists();
        }
        
        return view('live-events.show', compact('event','options','total_suara','sudah_vote'));
    }

    public function create()
    {
        $allowedRoles = ['pembina','dewan_penasihat','dewan_harian','koordinator_bidang'];
        if (!in_array(Auth::user()->role, $allowedRoles)) abort(403);
        return view('live-events.create');
    }

    public function store(Request $request)
    {
        $allowedRoles = ['pembina','dewan_penasihat','dewan_harian','koordinator_bidang'];
        if (!in_array(Auth::user()->role, $allowedRoles)) abort(403);

        $request->validate([
            'judul'       => 'required|min:5',
            'jenis'       => 'required|in:pemilu,lomba,voting_umum',
            'deskripsi'   => 'nullable',
            'mulai_at'    => 'nullable|date',
            'selesai_at'  => 'nullable|date',
            'kandidat'    => 'required|array|min:2',
            'kandidat.*'  => 'required|string|min:2',
        ]);

        $event = LiveEvent::create([
            'judul'       => $request->judul,
            'deskripsi'   => $request->deskripsi,
            'jenis'       => $request->jenis,
            'status'      => 'akan_datang',
            'mulai_at'    => $request->mulai_at,
            'selesai_at'  => $request->selesai_at,
            'dibuat_oleh' => Auth::user()->name,
        ]);

        foreach ($request->kandidat as $nama) {
            if (trim($nama)) {
                LiveEventOption::create([
                    'live_event_id' => $event->id,
                    'nama_kandidat' => trim($nama),
                    'jumlah_suara'  => 0,
                ]);
            }
        }

        return redirect('/live-events/' . $event->id)->with('success', 'Event berhasil dibuat!');
    }

    public function vote(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Login dulu untuk memilih.');
        }

        $event = LiveEvent::findOrFail($id);
        if ($event->status !== 'berlangsung') {
            return back()->with('error', 'Voting belum/sudah tidak aktif.');
        }

        $sudah_vote = LiveEventVote::where('live_event_id', $id)
            ->where('voter_username', Auth::user()->username)
            ->exists();
        if ($sudah_vote) {
            return back()->with('error', 'Kamu sudah memberikan suara.');
        }

        $request->validate(['option_id' => 'required|integer']);

        $option = LiveEventOption::where('id', $request->option_id)
            ->where('live_event_id', $id)
            ->firstOrFail();

        $option->jumlah_suara += 1;
        $option->save();

        LiveEventVote::create([
            'live_event_id'  => $id,
            'option_id'      => $request->option_id,
            'voter_username' => Auth::user()->username,
            'voter_name'     => Auth::user()->name,
        ]);

        return back()->with('success', 'Suara berhasil diberikan!');
    }

    public function updateStatus(Request $request, $id)
    {
        $allowedRoles = ['pembina','dewan_harian','dewan_penasihat'];
        if (!in_array(Auth::user()->role, $allowedRoles)) abort(403);

        $request->validate(['status' => 'required|in:akan_datang,berlangsung,selesai']);
        LiveEvent::findOrFail($id)->update(['status' => $request->status]);
        return back()->with('success', 'Status event diperbarui.');
    }
}
