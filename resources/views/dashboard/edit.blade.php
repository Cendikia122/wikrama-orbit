@extends('layouts.app')
@section('title', 'Edit Kegiatan')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs text-slate-400 mb-6">
        <a href="/dashboard" class="hover:text-slate-600 transition-colors">Dashboard</a>
        <span>&rsaquo;</span>
        <span class="text-slate-600 font-medium">Edit Kegiatan</span>
    </nav>

    {{-- Card --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100">
            <h1 class="text-base font-bold text-slate-900">Edit Data Kegiatan / Proker</h1>
            <p class="text-xs text-slate-400 mt-0.5">Perbarui detail, status kanban, dan persentase progress kegiatan.</p>
        </div>

        <form method="POST" action="/dashboard/{{ $kegiatan->id }}" class="px-6 py-5 space-y-4">
            @csrf
            @method('PUT')

            {{-- Nama Kegiatan --}}
            <div>
                <label class="form-label" for="title">Nama Kegiatan / Proker <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title"
                       value="{{ old('title', $kegiatan->title) }}"
                       placeholder="Min. 4 karakter"
                       class="form-input @error('title') border-red-400 focus:ring-red-400 @enderror" required>
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- PIC & Ketupel --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="form-label" for="penanggung_jawab">Penanggung Jawab (PIC) <span class="text-red-500">*</span></label>
                    <input type="text" id="penanggung_jawab" name="penanggung_jawab"
                           value="{{ old('penanggung_jawab', $kegiatan->penanggung_jawab) }}"
                           placeholder="Contoh: Sekbid 4 (Prestasi)"
                           class="form-input @error('penanggung_jawab') border-red-400 focus:ring-red-400 @enderror" required>
                </div>
                <div>
                    <label class="form-label" for="nama_ketua_pelaksana">Ketua Pelaksana Event</label>
                    <input type="text" id="nama_ketua_pelaksana" name="nama_ketua_pelaksana"
                           value="{{ old('nama_ketua_pelaksana', $kegiatan->nama_ketua_pelaksana) }}"
                           placeholder="Nama siswa penanggung jawab"
                           class="form-input">
                </div>
            </div>

            {{-- Kategori & Bidang PIC --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="form-label" for="kategori">Kategori <span class="text-red-500">*</span></label>
                    <select id="kategori" name="kategori" class="form-input" required>
                        <option value="" disabled>Pilih kategori...</option>
                        @foreach(['Program Kerja', 'Regulasi GDS', 'Bimbingan Prestasi', 'Aspirasi MPR'] as $kat)
                            <option value="{{ $kat }}"
                                {{ old('kategori', $kegiatan->kategori) === $kat ? 'selected' : '' }}>
                                {{ $kat }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="bidang_pic">Seksi Bidang Terkait</label>
                    <select id="bidang_pic" name="bidang_pic" class="form-input">
                        <option value="0" {{ old('bidang_pic', $kegiatan->bidang_pic) == 0 ? 'selected' : '' }}>Umum / Semua Bidang</option>
                        @for($b = 1; $b <= 10; $b++)
                            <option value="{{ $b }}" {{ old('bidang_pic', $kegiatan->bidang_pic) == $b ? 'selected' : '' }}>
                                Seksi Bidang {{ $b }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>

            {{-- Status Kanban, Prioritas, Progress --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <label class="form-label" for="kanban_status">Status Kanban</label>
                    <select id="kanban_status" name="kanban_status" class="form-input">
                        @foreach(['todo' => 'To Do', 'inprogress' => 'In Progress', 'blocked' => 'Blocked', 'done' => 'Done'] as $kVal => $kLbl)
                            <option value="{{ $kVal }}" {{ old('kanban_status', $kegiatan->kanban_status) === $kVal ? 'selected' : '' }}>
                                {{ $kLbl }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="prioritas">Prioritas</label>
                    <select id="prioritas" name="prioritas" class="form-input">
                        @foreach(['rendah' => 'Rendah', 'normal' => 'Normal', 'tinggi' => 'Tinggi', 'kritis' => 'Kritis'] as $pVal => $pLbl)
                            <option value="{{ $pVal }}" {{ old('prioritas', $kegiatan->prioritas) === $pVal ? 'selected' : '' }}>
                                {{ $pLbl }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="persentase_selesai">Progress (%)</label>
                    <input type="number" id="persentase_selesai" name="persentase_selesai" min="0" max="100"
                           value="{{ old('persentase_selesai', $kegiatan->persentase_selesai ?? 0) }}"
                           class="form-input">
                </div>
            </div>

            {{-- Target Selesai --}}
            <div>
                <label class="form-label" for="target_selesai">Target Selesai <span class="text-red-500">*</span></label>
                <input type="datetime-local" id="target_selesai" name="target_selesai"
                       value="{{ old('target_selesai', $kegiatan->target_selesai ? \Carbon\Carbon::parse($kegiatan->target_selesai)->format('Y-m-d\TH:i') : '') }}"
                       class="form-input @error('target_selesai') border-red-400 focus:ring-red-400 @enderror" required>
                @error('target_selesai')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Catatan Evaluasi --}}
            <div>
                <label class="form-label" for="catatan_evaluasi">Catatan Evaluasi / Notulensi <span class="text-red-500">*</span></label>
                <textarea id="catatan_evaluasi" name="catatan_evaluasi" rows="4"
                          placeholder="Min. 15 karakter — tuliskan notulensi rapat agar tidak terulang..."
                          class="form-input resize-none @error('catatan_evaluasi') border-red-400 focus:ring-red-400 @enderror" required>{{ old('catatan_evaluasi', $kegiatan->catatan_evaluasi) }}</textarea>
                @error('catatan_evaluasi')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Metadata readonly --}}
            <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 flex flex-wrap gap-4 text-xs text-slate-500">
                <span>ID Kegiatan: <strong class="text-slate-700">#{{ $kegiatan->id }}</strong></span>
                <span>Dibuat: <strong class="text-slate-700">{{ \Carbon\Carbon::parse($kegiatan->created_at)->format('d M Y') }}</strong></span>
                <span>Status Akhir: <strong class="text-slate-700">{{ $kegiatan->status ? 'Selesai (Done)' : 'Belum Selesai' }}</strong></span>
            </div>

            {{-- Actions --}}
            <div class="flex gap-3 pt-2">
                <a href="/dashboard"
                   class="flex-1 text-center py-2.5 border border-slate-200 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="flex-1 btn-primary justify-center py-2.5 rounded-xl text-sm font-semibold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
