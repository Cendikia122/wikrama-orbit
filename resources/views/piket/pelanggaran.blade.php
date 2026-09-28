@extends('layouts.app')
@section('title', 'Pencatatan Pelanggaran GDS')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Pencatatan Pelanggaran GDS</h1>
            <p class="text-sm text-slate-500 mt-1">Catat pelanggaran siswa secara digital — cepat, jelas, dan terarsip otomatis</p>
        </div>
        <div class="text-right">
            <span class="badge bg-blue-100 text-blue-800 text-sm py-1 px-3">{{ $pelanggaran_hari_ini ?? 0 }} pelanggaran hari ini</span>
        </div>
    </div>

    {{-- Filter & Action --}}
    <div class="flex flex-col sm:flex-row gap-4 justify-between items-center mb-8">
        <form method="GET" action="/piket/pelanggaran" class="w-full sm:w-auto">
            <select name="filter_tanggal" class="form-input bg-white shadow-sm w-full sm:w-auto" onchange="this.form.submit()">
                <option value="">Hari Ini</option>
                @foreach($all_dates ?? [] as $date)
                    <option value="{{ $date }}" {{ request('filter_tanggal') == $date ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                    </option>
                @endforeach
            </select>
        </form>

        <button onclick="document.getElementById('modalPelanggaran').classList.remove('hidden')" class="w-full sm:w-auto btn-primary bg-blue-800 hover:bg-blue-900 text-white py-3 px-6 rounded-xl shadow-md text-base justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Catat Pelanggaran Baru
        </button>
    </div>

    {{-- Data Table --}}
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        @if(isset($pelanggaran) && count($pelanggaran) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold">
                        <tr>
                            <th class="px-4 py-3">Jam</th>
                            <th class="px-4 py-3">Nama Siswa</th>
                            <th class="px-4 py-3">Kelas</th>
                            <th class="px-4 py-3">Jenis Pelanggaran</th>
                            <th class="px-4 py-3">Tingkat</th>
                            <th class="px-4 py-3">Dicatat Oleh</th>
                            <th class="px-4 py-3 text-center">Hapus</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($pelanggaran as $p)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 text-slate-500">{{ \Carbon\Carbon::parse($p->created_at)->format('H:i') }}</td>
                            <td class="px-4 py-3 font-medium text-slate-900">{{ $p->nama_siswa }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $p->kelas }}</td>
                            <td class="px-4 py-3 text-slate-800">{{ $p->jenis_pelanggaran }}</td>
                            <td class="px-4 py-3">
                                @if(strtolower($p->tingkat_keparahan) == 'ringan')
                                    <span class="badge bg-yellow-100 text-yellow-800">Ringan</span>
                                @elseif(strtolower($p->tingkat_keparahan) == 'sedang')
                                    <span class="badge bg-orange-100 text-orange-800">Sedang</span>
                                @else
                                    <span class="badge bg-red-100 text-red-800">Berat</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-slate-500">{{ $p->dicatat_oleh }}</td>
                            <td class="px-4 py-3 text-center">
                                @if(in_array(Auth::user()->role, ['pembina', 'dewan_harian']))
                                <form method="POST" action="/piket/pelanggaran/{{ $p->id }}" onsubmit="return confirm('Hapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="py-16 text-center">
                <div class="text-4xl mb-4">🎉</div>
                <p class="text-slate-600 font-medium text-lg">Tidak ada pelanggaran tercatat hari ini</p>
                <p class="text-slate-400 text-sm mt-1">Terus pertahankan kedisiplinan!</p>
            </div>
        @endif
    </div>
</div>

{{-- Modal --}}
<div id="modalPelanggaran" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg my-8 relative">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center sticky top-0 bg-white rounded-t-2xl z-10">
            <h3 class="font-bold text-lg text-slate-900">Catat Pelanggaran</h3>
            <button onclick="document.getElementById('modalPelanggaran').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        
        <form method="POST" action="/piket/pelanggaran" class="p-6 space-y-5">
            @csrf
            
            <div>
                <label class="form-label font-bold text-slate-700">Nama Lengkap Siswa</label>
                <input type="text" name="nama_siswa" class="form-input text-lg py-3" placeholder="Contoh: Budi Santoso" required>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label font-bold text-slate-700">Kelas</label>
                    <input type="text" name="kelas" class="form-input text-lg py-3" placeholder="X RPL 1" required>
                </div>
                <div>
                    <label class="form-label font-bold text-slate-700">Jurusan</label>
                    <select name="jurusan" class="form-input text-lg py-3" required>
                        <option value="">Pilih Jurusan</option>
                        <option value="RPL">RPL</option>
                        <option value="TKJ">TKJ</option>
                        <option value="DKV">DKV</option>
                        <option value="OTKP">OTKP</option>
                        <option value="BDP">BDP</option>
                        <option value="Kuliner">Kuliner</option>
                        <option value="Akuntansi">Akuntansi</option>
                        <option value="Farmasi">Farmasi</option>
                        <option value="Lain-lain">Lain-lain</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="form-label font-bold text-slate-700">Jenis Pelanggaran</label>
                <select name="jenis_pelanggaran" class="form-input text-lg py-3" required>
                    <option value="">Pilih Pelanggaran</option>
                    @foreach($jenis_list ?? ['Atribut Tidak Lengkap', 'Terlambat Masuk', 'Tidak Membawa Tumbler', 'Tidak Memakai Sabuk', 'Rambut Tidak Rapi', 'Seragam Tidak Sesuai', 'Sepatu Tidak Sesuai', 'Membawa Barang Terlarang', 'HP di Sekolah (melanggar aturan)', 'Lain-lain'] as $jenis)
                        <option value="{{ $jenis }}">{{ $jenis }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="form-label font-bold text-slate-700 mb-2">Tingkat Keparahan</label>
                <div class="grid grid-cols-3 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" name="tingkat_keparahan" value="Ringan" class="peer sr-only" required>
                        <div class="text-center py-3 rounded-xl border-2 border-slate-200 peer-checked:border-yellow-500 peer-checked:bg-yellow-50 text-slate-600 peer-checked:text-yellow-700 font-bold transition-all">
                            Ringan
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="tingkat_keparahan" value="Sedang" class="peer sr-only">
                        <div class="text-center py-3 rounded-xl border-2 border-slate-200 peer-checked:border-orange-500 peer-checked:bg-orange-50 text-slate-600 peer-checked:text-orange-700 font-bold transition-all">
                            Sedang
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="tingkat_keparahan" value="Berat" class="peer sr-only">
                        <div class="text-center py-3 rounded-xl border-2 border-slate-200 peer-checked:border-red-500 peer-checked:bg-red-50 text-slate-600 peer-checked:text-red-700 font-bold transition-all">
                            Berat
                        </div>
                    </label>
                </div>
            </div>

            <div>
                <label class="form-label font-bold text-slate-700">Keterangan Tambahan (Opsional)</label>
                <textarea name="keterangan_tambahan" class="form-input" rows="2" placeholder="Detail spesifik pelanggaran..."></textarea>
            </div>

            <div class="pt-4 sticky bottom-0 bg-white pb-2">
                <button type="submit" class="w-full btn-primary bg-blue-800 hover:bg-blue-900 py-4 text-lg justify-center rounded-xl shadow-lg">
                    Simpan Pelanggaran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
