@extends('layouts.app')
@section('title', 'Absensi GDS OSIS-MPR')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="flex border-b border-slate-200 mb-8">
        <a href="/piket" class="px-4 py-2 border-b-2 border-transparent text-slate-500 hover:text-slate-700 font-medium text-sm">Jadwal GDS</a>
        <a href="/piket/absensi" class="px-4 py-2 border-b-2 border-blue-800 text-blue-800 font-semibold text-sm">Absensi GDS</a>
        <a href="/piket/pelanggaran" class="px-4 py-2 border-b-2 border-transparent text-slate-500 hover:text-slate-700 font-medium text-sm">Pelanggaran Siswa</a>
    </div>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Absensi GDS OSIS-MPR</h1>
            <p class="text-sm text-slate-500 mt-1">Monitoring kehadiran anggota OSIS pada jadwal piket GDS</p>
        </div>
        @if(in_array(Auth::user()->role, ['pembina', 'dewan_penasihat', 'mpr', 'dewan_harian', 'koordinator_bidang']))
        <button onclick="document.getElementById('modalAbsensi').classList.remove('hidden')" class="btn-primary py-2.5 px-5">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Catat Absensi
        </button>
        @endif
    </div>

    {{-- Stats Row --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total GDS Tercatat</p>
            <p class="text-2xl font-bold text-blue-600 mt-1">{{ $total_gds ?? 0 }}</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total Tidak Hadir</p>
            <p class="text-2xl font-bold text-red-600 mt-1">{{ $total_tidak_hadir ?? 0 }}</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total Terlambat</p>
            <p class="text-2xl font-bold text-amber-600 mt-1">{{ $total_terlambat ?? 0 }}</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total Poin Pelanggaran GDS</p>
            <p class="text-2xl font-bold text-slate-700 mt-1">{{ $total_poin ?? 0 }}</p>
        </div>
    </div>

    {{-- Rekap Per Anggota --}}
    <h2 class="text-lg font-bold text-slate-900 mb-4">Rekap Per Anggota</h2>
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mb-10">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Nama Anggota</th>
                        <th class="px-6 py-4">Divisi</th>
                        <th class="px-6 py-4 text-center">Total GDS</th>
                        <th class="px-6 py-4 text-center">Tidak Hadir</th>
                        <th class="px-6 py-4 text-center">Terlambat</th>
                        <th class="px-6 py-4 text-center">Total Poin</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($summary ?? [] as $index => $s)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $s->nama_anggota }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $s->divisi }}</td>
                        <td class="px-6 py-4 text-center">{{ $s->total_gds }}</td>
                        <td class="px-6 py-4 text-center font-medium text-red-600">{{ $s->tidak_hadir }}</td>
                        <td class="px-6 py-4 text-center font-medium text-amber-600">{{ $s->terlambat }}</td>
                        <td class="px-6 py-4 text-center font-bold">{{ $s->total_poin }}</td>
                        <td class="px-6 py-4">
                            @if($s->tidak_hadir == 0)
                                <span class="badge bg-emerald-100 text-emerald-800">Disiplin</span>
                            @elseif($s->tidak_hadir <= 2)
                                <span class="badge bg-amber-100 text-amber-800">Perlu Perhatian</span>
                            @else
                                <span class="badge bg-red-100 text-red-800">Kritis</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-slate-500">
                            Belum ada rekap data absensi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Detail Absensi Log --}}
    <h2 class="text-lg font-bold text-slate-900 mb-4">Detail Absensi Log</h2>
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Hari</th>
                        <th class="px-4 py-3">Nama Anggota</th>
                        <th class="px-4 py-3">Divisi</th>
                        <th class="px-4 py-3">Jobdesk</th>
                        <th class="px-4 py-3">Penempatan</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Poin</th>
                        <th class="px-4 py-3">Dicatat Oleh</th>
                        <th class="px-4 py-3 text-center">Hapus</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($absensi ?? [] as $log)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 text-slate-600">{{ \Carbon\Carbon::parse($log->tanggal)->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $log->hari }}</td>
                        <td class="px-4 py-3 font-medium text-slate-900">{{ $log->nama_anggota }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $log->divisi }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $log->jobdesk }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $log->penempatan }}</td>
                        <td class="px-4 py-3">
                            @if($log->status_kehadiran == 'hadir')
                                <span class="badge bg-emerald-100 text-emerald-800">Hadir</span>
                            @elseif($log->status_kehadiran == 'terlambat')
                                <span class="badge bg-amber-100 text-amber-800">Terlambat</span>
                            @else
                                <span class="badge bg-red-100 text-red-800">Tidak Hadir</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-bold">{{ $log->poin_pelanggaran > 0 ? $log->poin_pelanggaran : '-' }}</td>
                        <td class="px-4 py-3 text-slate-500 text-xs">{{ $log->dicatat_oleh }}</td>
                        <td class="px-4 py-3 text-center">
                            @if(in_array(Auth::user()->role, ['pembina', 'dewan_harian']))
                            <form method="POST" action="/piket/absensi/{{ $log->id }}" onsubmit="return confirm('Hapus absensi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-4 py-6 text-center text-slate-500">Belum ada log absensi tercatat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200">
            {{ $absensi->links() ?? '' }}
        </div>
    </div>

</div>

{{-- Modal Catat Absensi --}}
<div id="modalAbsensi" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg my-8">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-lg text-slate-900">Catat Absensi GDS</h3>
            <button onclick="document.getElementById('modalAbsensi').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        
        <form method="POST" action="/piket/absensi" class="p-6 space-y-4">
            @csrf
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Hari</label>
                    <select name="hari" class="form-input" required>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="form-label">Nama Lengkap Anggota</label>
                <input type="text" name="nama_anggota" class="form-input" placeholder="Nama lengkap anggota" required>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Divisi</label>
                    <select name="divisi" class="form-input" required>
                        <option value="">Pilih Divisi</option>
                        <option value="DH">DH</option>
                        <option value="MPR">MPR</option>
                        @for($i=1; $i<=10; $i++)
                            <option value="SEKBID {{ $i }}">SEKBID {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="form-label">Jobdesk</label>
                    <select name="jobdesk" class="form-input" required>
                        <option value="">Pilih Jobdesk</option>
                        <option value="SIM">SIM</option>
                        <option value="Tas">Tas</option>
                        <option value="Pengawas & Pencatat Atribut">Pengawas & Pencatat Atribut</option>
                        <option value="Atribut Wanita">Atribut Wanita</option>
                        <option value="Atribut Pria">Atribut Pria</option>
                        <option value="Pengawas & Pencatat Tas">Pengawas & Pencatat Tas</option>
                        <option value="Lain-lain">Lain-lain</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="form-label">Penempatan</label>
                <select name="penempatan" class="form-input" required>
                    <option value="">Pilih Penempatan</option>
                    <option value="Parkiran">Parkiran</option>
                    <option value="Belakang">Belakang</option>
                    <option value="Pintu Masuk">Pintu Masuk</option>
                    <option value="Lain-lain">Lain-lain</option>
                </select>
            </div>

            <div>
                <label class="form-label">Status Kehadiran</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status_kehadiran" value="hadir" class="w-4 h-4 text-emerald-600" onchange="togglePoin()" required checked>
                        <span class="text-sm font-medium text-slate-700">Hadir</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status_kehadiran" value="terlambat" class="w-4 h-4 text-amber-600" onchange="togglePoin()">
                        <span class="text-sm font-medium text-slate-700">Terlambat</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status_kehadiran" value="tidak_hadir" class="w-4 h-4 text-red-600" onchange="togglePoin()">
                        <span class="text-sm font-medium text-slate-700">Tidak Hadir</span>
                    </label>
                </div>
            </div>

            <div id="poinContainer" class="hidden">
                <label class="form-label">Poin Pelanggaran (0-10)</label>
                <input type="number" name="poin_pelanggaran" min="0" max="10" value="0" class="form-input">
            </div>

            <div>
                <label class="form-label">Catatan (Opsional)</label>
                <textarea name="catatan" class="form-input" rows="2" placeholder="Alasan tidak hadir/terlambat..."></textarea>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modalAbsensi').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg">Batal</button>
                <button type="submit" class="btn-primary">Simpan Absensi</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function togglePoin() {
        const hadir = document.querySelector('input[name="status_kehadiran"][value="hadir"]').checked;
        const poinContainer = document.getElementById('poinContainer');
        if (hadir) {
            poinContainer.classList.add('hidden');
            document.querySelector('input[name="poin_pelanggaran"]').value = 0;
        } else {
            poinContainer.classList.remove('hidden');
        }
    }
</script>
@endpush
@endsection
