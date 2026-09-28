@extends('layouts.app')
@section('title', 'Jadwal Piket GDS')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="bg-blue-50 border-l-4 border-blue-800 p-4 mb-6 rounded-r-lg">
        <p class="text-sm text-blue-800 font-medium">Halaman ini hanya dapat diakses oleh Anggota OSIS-MPR yang telah login.</p>
    </div>

    <div class="flex border-b border-slate-200 mb-8">
        <a href="/piket" class="px-4 py-2 border-b-2 border-blue-800 text-blue-800 font-semibold text-sm">Jadwal GDS</a>
        @if(in_array(Auth::user()->role, ['pembina','dewan_penasihat','mpr','dewan_harian','koordinator_bidang']))
        <a href="/piket/absensi" class="px-4 py-2 border-b-2 border-transparent text-slate-500 hover:text-slate-700 font-medium text-sm">Absensi GDS</a>
        <a href="/piket/pelanggaran" class="px-4 py-2 border-b-2 border-transparent text-slate-500 hover:text-slate-700 font-medium text-sm">Pelanggaran Siswa</a>
        @endif
    </div>
    {{-- ── Page Header ── --}}
    <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background:#1E3A8A;">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Jadwal Piket GDS</h1>
                <p class="text-sm text-slate-500 mt-0.5">Penugasan Gerakan Disiplin Siswa (GDS) pagi di gerbang masuk SMKS Wikrama Bogor.</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            @auth
                <a href="/piket/my-schedule" class="btn-primary" style="background:#0F172A;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Lihat Jadwal Piketku
                </a>

                @if(in_array(Auth::user()->role, ['dewan_harian', 'pembina', 'dewan_penasihat']))
                    <button onclick="document.getElementById('uploadModal').classList.remove('hidden')"
                            class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Upload Jadwal (CSV)
                    </button>
                @endif
            @endauth
        </div>
    </div>

    {{-- ── Today's Piket ── --}}
    <div class="mb-8">
        @if(isset($piket_hari_ini) && $piket_hari_ini->count() > 0)
            <div class="bg-gradient-to-r from-navy to-navy-dark text-white rounded-2xl p-6 shadow-lg" style="background:linear-gradient(135deg, #0F172A 0%, #1E3A8A 100%);">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <p class="text-xs font-bold text-blue-200 uppercase tracking-widest">
                        Petugas Piket GDS Hari Ini &bull; {{ $today->isoFormat('dddd, D MMMM Y') }}
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 mt-3">
                    @foreach($piket_hari_ini as $item)
                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-3.5 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-white/20 text-white font-bold flex items-center justify-center shrink-0">
                                {{ strtoupper(substr($item->nama_petugas, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-white truncate">{{ $item->nama_petugas }}</p>
                                <p class="text-xs text-blue-200 truncate">{{ $item->jabatan_petugas ?? 'Petugas GDS' }} &bull; Shift {{ $item->shift }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="bg-slate-100 border border-slate-200 rounded-2xl p-5 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-slate-200 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-700">Tidak ada piket terjadwal untuk hari ini</p>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $today->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
            </div>
        @endif
    </div>

    {{-- ── Weekly Schedule Table ── --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900">Jadwal Minggu Ini</h2>
            <span class="text-xs text-slate-400">{{ isset($jadwal) ? $jadwal->count() : 0 }} giliran petugas</span>
        </div>

        @if(isset($jadwal) && $jadwal->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 text-xs font-semibold uppercase tracking-wider text-left">
                            <th class="px-6 py-3.5">Hari</th>
                            <th class="px-6 py-3.5">Tanggal</th>
                            <th class="px-6 py-3.5">Nama Petugas</th>
                            <th class="px-6 py-3.5">Jabatan / Sekbid</th>
                            <th class="px-6 py-3.5">Shift</th>
                            <th class="px-6 py-3.5">Jobdesk</th>
                            <th class="px-6 py-3.5">Penempatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($jadwal as $j)
                            @php
                                $isToday = \Carbon\Carbon::parse($j->tanggal)->isToday();
                            @endphp
                            <tr class="{{ $isToday ? 'bg-amber-50/50 font-medium' : 'hover:bg-slate-50' }} transition-colors">
                                <td class="px-6 py-3.5 font-bold {{ $isToday ? 'text-amber-900' : 'text-slate-900' }}">
                                    {{ $j->hari ?? \Carbon\Carbon::parse($j->tanggal)->isoFormat('dddd') }}
                                    @if($isToday)
                                        <span class="badge bg-red-100 text-red-700 text-xs ml-1">Hari Ini</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3.5 text-slate-600 text-xs">
                                    {{ \Carbon\Carbon::parse($j->tanggal)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-3.5 font-semibold text-slate-900">{{ $j->nama_petugas }}</td>
                                <td class="px-6 py-3.5 text-slate-600 text-xs">{{ $j->jabatan_petugas ?? 'Petugas GDS' }}</td>
                                <td class="px-6 py-3.5">
                                    <span class="badge bg-slate-100 text-slate-700 text-xs">
                                        Shift {{ $j->shift ?? 'Pagi' }}
                                    </span>
                                </td>
                                <td class="px-6 py-3.5 text-slate-600 text-xs">{{ $j->jobdesk ?? '-' }}</td>
                                <td class="px-6 py-3.5 text-slate-600 text-xs">{{ $j->penempatan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-sm text-slate-500 font-medium">Jadwal piket minggu ini belum diunggah</p>
                @auth
                    @if(in_array(Auth::user()->role, ['dewan_harian', 'pembina', 'dewan_penasihat']))
                        <p class="text-xs text-slate-400 mt-1">Gunakan tombol "Upload Jadwal (CSV)" di atas untuk mengunggah berkas jadwal.</p>
                    @endif
                @endauth
            </div>
        @endif
    </div>

</div>

{{-- ── Upload CSV Modal ── --}}
@auth
    @if(in_array(Auth::user()->role, ['dewan_harian', 'pembina', 'dewan_penasihat']))
        <div id="uploadModal"
             class="hidden fixed inset-0 z-50 flex items-center justify-center px-4"
             style="background: rgba(15,23,42,0.5);">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-base font-bold text-slate-900">Upload Jadwal Piket (CSV)</h3>
                    <button onclick="document.getElementById('uploadModal').classList.add('hidden')"
                            class="w-8 h-8 rounded-lg border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-700 transition-colors">
                        &times;
                    </button>
                </div>

                <form method="POST" action="/piket/upload" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="form-label" for="csv_file">Pilih Berkas CSV <span class="text-red-500">*</span></label>
                        <input id="csv_file" name="csv_file" type="file" accept=".csv,text/csv,text/plain"
                               class="form-input" required>
                    </div>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-xs text-slate-600 leading-relaxed">
                        <p class="font-bold text-slate-700 mb-1">Format Kolom CSV (Baris 1 = Header):</p>
                        <code class="text-navy bg-white border border-slate-200 px-1 py-0.5 rounded block mb-1">
                            tanggal, hari, nama_petugas, jabatan_petugas, bidang_petugas, shift
                        </code>
                        <p class="text-slate-500">Contoh isi: <code>2026-09-29, Selasa, Ketua OSIS 2, Dewan Harian, 0, Pagi</code></p>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2">
                        <button type="button"
                                onclick="document.getElementById('uploadModal').classList.add('hidden')"
                                class="px-4 py-2 border border-slate-200 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-50">
                            Batal
                        </button>
                        <button type="submit" class="btn-primary text-xs px-4 py-2">
                            Mulai Impor CSV
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endauth
@endsection
