@extends('layouts.app')
@section('title', 'Dashboard Proker')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- ── PROMINENT BOLD BANNER: JADWAL PIKET GDS ANDA ── --}}
    @if(isset($myNextPiket) && $myNextPiket)
        @php
            $piketTgl = \Carbon\Carbon::parse($myNextPiket->tanggal);
            $isPiketToday = $piketTgl->isToday();
            $isPiketTomorrow = $piketTgl->isTomorrow();
        @endphp
        <div class="mb-8 rounded-2xl p-5 md:p-6 text-white shadow-md flex items-center justify-between gap-4 flex-wrap"
             style="background: linear-gradient(135deg, #0F172A 0%, #1E3A8A 100%);">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center text-2xl shrink-0 border border-white/30">
                    🛡️
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs uppercase tracking-widest text-blue-200 font-bold">Jadwal Tugas Pengurus</span>
                        <span class="badge {{ $isPiketToday ? 'bg-red-500 text-white animate-pulse' : 'bg-white/20 text-white' }} text-xs">
                            {{ $isPiketToday ? 'HARI INI' : ($isPiketTomorrow ? 'BESOK PAGI' : $piketTgl->diffForHumans()) }}
                        </span>
                    </div>
                    <p class="text-xl md:text-2xl font-black text-white mt-1">
                        Kapan Sih Anda GDS? <span class="underline decoration-amber-400 decoration-2">{{ $piketTgl->isoFormat('dddd, D MMMM Y') }}</span>
                    </p>
                    <p class="text-xs text-blue-200 mt-1">
                        Pukul 05.50 - 07.15 WIB &bull; Shift {{ $myNextPiket->shift }} &bull; Pos Gerbang Masuk Wikrama
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="/piket/my-schedule" class="px-4 py-2 bg-white text-navy font-bold rounded-xl text-xs hover:bg-blue-50 transition-colors" style="color:#0F172A; text-decoration:none;">
                    Buka Jadwal Piketku &rarr;
                </a>
            </div>
        </div>
    @endif

    {{-- ── Page Header ── --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Dashboard Proker OSIS-MPR</h1>
            <p class="text-sm text-slate-500 mt-1">Manajemen to-do list, kanban kegiatan, dan progress real-time untuk Pembina & Pengurus.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="openModal('addModal')"
                    class="btn-primary px-5 py-2.5 rounded-xl shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                + Tambah Kegiatan
            </button>
        </div>
    </div>

    {{-- ── Stats Bar ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Total Proker</p>
            <p class="text-3xl font-extrabold text-slate-900">{{ $total }}</p>
            <p class="text-xs text-slate-400 mt-1">Keseluruhan kegiatan</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Belum Selesai</p>
            <p class="text-3xl font-extrabold text-amber-500">{{ $belum_selesai }}</p>
            <p class="text-xs text-slate-400 mt-1">Sedang dikawal pengurus</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Selesai</p>
            <p class="text-3xl font-extrabold text-emerald-700">{{ $selesai }}</p>
            <p class="text-xs text-slate-400 mt-1">Berhasil dituntaskan</p>
        </div>
        <div class="bg-white border {{ $overdue > 0 ? 'border-red-300 bg-red-50/40' : 'border-slate-200' }} rounded-2xl p-5 shadow-sm">
            <p class="text-xs font-semibold {{ $overdue > 0 ? 'text-red-600' : 'text-slate-500' }} uppercase tracking-wider mb-1.5">Lewat Tenggat</p>
            <p class="text-3xl font-extrabold {{ $overdue > 0 ? 'text-red-600' : 'text-slate-900' }}">{{ $overdue }}</p>
            <p class="text-xs {{ $overdue > 0 ? 'text-red-500 font-semibold' : 'text-slate-400' }} mt-1">
                {{ $overdue > 0 ? 'Segera evaluasi & tindak lanjuti!' : 'Semua tepat waktu ✓' }}
            </p>
        </div>
    </div>

    {{-- ── Navigation & Filter Bar ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        {{-- View Tabs --}}
        <div class="flex gap-1 bg-slate-100 border border-slate-200 rounded-xl p-1 w-fit">
            <a href="/dashboard?tab=kanban&bidang={{ $bidangFilter }}"
               class="px-4 py-2 text-xs font-bold rounded-lg transition-all flex items-center gap-1.5 {{ $tab === 'kanban' ? 'bg-white text-slate-900 shadow-sm border border-slate-200' : 'text-slate-500 hover:text-slate-800' }}"
               style="text-decoration:none;">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/></svg>
                Papan Kanban
            </a>
            <a href="/dashboard?tab=belum&bidang={{ $bidangFilter }}"
               class="px-4 py-2 text-xs font-bold rounded-lg transition-all flex items-center gap-1.5 {{ $tab === 'belum' ? 'bg-white text-slate-900 shadow-sm border border-slate-200' : 'text-slate-500 hover:text-slate-800' }}"
               style="text-decoration:none;">
                Daftar Belum Selesai
                @if($belum_selesai > 0)
                    <span class="inline-flex items-center justify-center px-1.5 py-0.2 bg-amber-100 text-amber-800 text-[10px] rounded-full font-black">{{ $belum_selesai }}</span>
                @endif
            </a>
            <a href="/dashboard?tab=selesai&bidang={{ $bidangFilter }}"
               class="px-4 py-2 text-xs font-bold rounded-lg transition-all flex items-center gap-1.5 {{ $tab === 'selesai' ? 'bg-white text-slate-900 shadow-sm border border-slate-200' : 'text-slate-500 hover:text-slate-800' }}"
               style="text-decoration:none;">
                Selesai
                @if($selesai > 0)
                    <span class="inline-flex items-center justify-center px-1.5 py-0.2 bg-emerald-100 text-emerald-800 text-[10px] rounded-full font-black">{{ $selesai }}</span>
                @endif
            </a>
        </div>

        {{-- Sekbid Filter --}}
        <div class="flex items-center gap-2">
            <label for="filterBidang" class="text-xs font-bold text-slate-500 uppercase tracking-wider">Filter Bidang:</label>
            <select id="filterBidang" onchange="window.location.href='/dashboard?tab={{ $tab }}&bidang=' + this.value"
                    class="form-input text-xs py-1.5 px-3 rounded-lg max-w-xs" style="font-size:0.8rem;">
                <option value="all" {{ $bidangFilter === 'all' ? 'selected' : '' }}>Semua Bidang / Umum</option>
                @for($b = 1; $b <= 10; $b++)
                    <option value="{{ $b }}" {{ (string)$bidangFilter === (string)$b ? 'selected' : '' }}>
                        Seksi Bidang {{ $b }}
                    </option>
                @endfor
            </select>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════════ --}}
    {{-- TAB 1: KANBAN BOARD VIEW --}}
    {{-- ════════════════════════════════════════════════════════════ --}}
    @if($tab === 'kanban')
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

            {{-- 1. To Do Column --}}
            <div class="bg-slate-100/70 border border-slate-200 rounded-2xl p-4 flex flex-col min-h-[480px]">
                <div class="flex items-center justify-between mb-3 px-1">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span>
                        <h3 class="text-xs font-extrabold text-slate-700 uppercase tracking-wider">To Do (Akan Dikerjakan)</h3>
                    </div>
                    <span class="badge bg-slate-200 text-slate-700 font-bold text-xs">{{ $kanbanTodo->count() }}</span>
                </div>

                <div class="space-y-3 flex-1 overflow-y-auto">
                    @forelse($kanbanTodo as $item)
                        @include('dashboard._kanban_card', ['item' => $item])
                    @empty
                        <div class="h-32 flex items-center justify-center border border-dashed border-slate-300 rounded-xl text-slate-400 text-xs">
                            Tidak ada item to do
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- 2. In Progress Column --}}
            <div class="bg-blue-50/40 border border-blue-200/80 rounded-2xl p-4 flex flex-col min-h-[480px]">
                <div class="flex items-center justify-between mb-3 px-1">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500 animate-pulse"></span>
                        <h3 class="text-xs font-extrabold text-blue-900 uppercase tracking-wider">In Progress (Sedang Jalan)</h3>
                    </div>
                    <span class="badge bg-blue-100 text-blue-800 font-bold text-xs">{{ $kanbanInProgress->count() }}</span>
                </div>

                <div class="space-y-3 flex-1 overflow-y-auto">
                    @forelse($kanbanInProgress as $item)
                        @include('dashboard._kanban_card', ['item' => $item])
                    @empty
                        <div class="h-32 flex items-center justify-center border border-dashed border-blue-200 rounded-xl text-blue-400 text-xs">
                            Tidak ada kegiatan berlangsung
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- 3. Blocked Column --}}
            <div class="bg-red-50/40 border border-red-200/80 rounded-2xl p-4 flex flex-col min-h-[480px]">
                <div class="flex items-center justify-between mb-3 px-1">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                        <h3 class="text-xs font-extrabold text-red-900 uppercase tracking-wider">Blocked (Terkendala)</h3>
                    </div>
                    <span class="badge bg-red-100 text-red-800 font-bold text-xs">{{ $kanbanBlocked->count() }}</span>
                </div>

                <div class="space-y-3 flex-1 overflow-y-auto">
                    @forelse($kanbanBlocked as $item)
                        @include('dashboard._kanban_card', ['item' => $item])
                    @empty
                        <div class="h-32 flex items-center justify-center border border-dashed border-red-200 rounded-xl text-red-400 text-xs">
                            Tidak ada kendala / blocked ✓
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- 4. Done Column --}}
            <div class="bg-emerald-50/40 border border-emerald-200/80 rounded-2xl p-4 flex flex-col min-h-[480px]">
                <div class="flex items-center justify-between mb-3 px-1">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <h3 class="text-xs font-extrabold text-emerald-900 uppercase tracking-wider">Done (Selesai)</h3>
                    </div>
                    <span class="badge bg-emerald-100 text-emerald-800 font-bold text-xs">{{ $kanbanDone->count() }}</span>
                </div>

                <div class="space-y-3 flex-1 overflow-y-auto">
                    @forelse($kanbanDone as $item)
                        @include('dashboard._kanban_card', ['item' => $item])
                    @empty
                        <div class="h-32 flex items-center justify-center border border-dashed border-emerald-200 rounded-xl text-emerald-400 text-xs">
                            Belum ada proker yang selesai
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    {{-- ════════════════════════════════════════════════════════════ --}}
    {{-- TAB 2 & 3: LIST VIEW (BELUM / SELESAI) --}}
    {{-- ════════════════════════════════════════════════════════════ --}}
    @else
        @if($kegiatan->isEmpty())
            <div class="bg-white border border-dashed border-slate-300 rounded-2xl py-16 text-center">
                <div class="text-4xl mb-3">📋</div>
                <p class="font-bold text-slate-800 text-base mb-1">Belum ada kegiatan pada tab ini</p>
                <p class="text-sm text-slate-400 mb-5">{{ $tab === 'belum' ? 'Tambahkan kegiatan baru untuk memulai manajemen proker.' : 'Belum ada kegiatan yang diselesaikan.' }}</p>
                @if($tab === 'belum')
                    <button onclick="openModal('addModal')" class="btn-primary text-xs px-4 py-2">
                        + Tambah Kegiatan Baru
                    </button>
                @endif
            </div>
        @else
            <div class="space-y-4">
                @foreach($kegiatan as $item)
                    @php
                        $isOverdue = $item->target_selesai < now() && $item->status == 0;
                        $kategoriColor = match($item->kategori) {
                            'Regulasi GDS'       => 'bg-blue-50 text-blue-700 border-blue-200',
                            'Bimbingan Prestasi' => 'bg-purple-50 text-purple-700 border-purple-200',
                            'Program Kerja'      => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'Aspirasi MPR'       => 'bg-orange-50 text-orange-700 border-orange-200',
                            default              => 'bg-slate-100 text-slate-600 border-slate-200',
                        };
                        $priorityColor = match($item->prioritas) {
                            'kritis' => 'bg-red-500 text-white font-bold',
                            'tinggi' => 'bg-orange-100 text-orange-800 border-orange-300 font-bold',
                            'rendah' => 'bg-slate-100 text-slate-600',
                            default  => 'bg-blue-50 text-blue-700 border-blue-200',
                        };
                    @endphp
                    <div class="bg-white border {{ $isOverdue ? 'border-red-300' : 'border-slate-200' }} rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">

                            <div class="flex-1 min-w-0">
                                {{-- Badges --}}
                                <div class="flex items-center gap-2 flex-wrap mb-2">
                                    <span class="badge border {{ $kategoriColor }} text-xs">{{ $item->kategori }}</span>
                                    @if($item->bidang_pic)
                                        <span class="badge bg-slate-100 text-slate-700 border border-slate-200 text-xs">Sekbid {{ $item->bidang_pic }}</span>
                                    @endif
                                    @if($item->prioritas)
                                        <span class="badge border {{ $priorityColor }} text-xs">Prioritas: {{ ucfirst($item->prioritas) }}</span>
                                    @endif
                                    @if($isOverdue)
                                        <span class="badge bg-red-100 text-red-700 border border-red-300 font-bold text-xs">⚠ Lewat Tenggat Waktu</span>
                                    @endif
                                </div>

                                {{-- Title --}}
                                <h3 class="text-base font-bold text-slate-900 leading-snug {{ $item->status == 1 ? 'line-through text-slate-400' : '' }}">
                                    {{ $item->title }}
                                </h3>

                                {{-- Progress bar --}}
                                <div class="mt-3 max-w-md">
                                    <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
                                        <span>Progress: <strong>{{ $item->persentase_selesai ?? ($item->status ? 100 : 0) }}%</strong></span>
                                        <span>Status: <strong class="uppercase text-[11px]">{{ $item->kanban_status ?? ($item->status ? 'Done' : 'In Progress') }}</strong></span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden border border-slate-200">
                                        <div class="h-2 rounded-full transition-all duration-500 {{ $item->status ? 'bg-emerald-600' : 'bg-navy' }}"
                                             style="width: {{ $item->persentase_selesai ?? ($item->status ? 100 : 0) }}%"></div>
                                    </div>
                                </div>

                                {{-- Metadata --}}
                                <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-500 mt-3">
                                    <span class="flex items-center gap-1 font-medium">
                                        PIC: {{ $item->penanggung_jawab }}
                                    </span>
                                    @if($item->nama_ketua_pelaksana)
                                        <span class="flex items-center gap-1">
                                            Ketupel: <strong class="text-slate-700">{{ $item->nama_ketua_pelaksana }}</strong>
                                        </span>
                                    @endif
                                    <span class="flex items-center gap-1 {{ $isOverdue ? 'text-red-600 font-bold' : '' }}">
                                        Target: {{ \Carbon\Carbon::parse($item->target_selesai)->format('d M Y, H:i') }} WIB
                                    </span>
                                    @if($item->done_time)
                                        <span class="flex items-center gap-1 text-emerald-700 font-semibold">
                                            Selesai: {{ \Carbon\Carbon::parse($item->done_time)->format('d M Y, H:i') }} WIB
                                        </span>
                                    @endif
                                </div>

                                {{-- Catatan Evaluasi --}}
                                <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-600 leading-relaxed mt-3">
                                    <span class="font-bold text-slate-700">📝 Catatan Evaluasi / Notulensi:</span> {{ $item->catatan_evaluasi }}
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex md:flex-col items-center md:items-end gap-2 shrink-0">
                                <form method="POST" action="/dashboard/{{ $item->id }}/toggle">
                                    @csrf
                                    @method('PATCH')
                                    @if($item->status == 0)
                                        <button type="submit" class="flex items-center gap-1.5 bg-emerald-50 border border-emerald-300 text-emerald-700 text-xs font-bold px-3 py-1.5 rounded-lg hover:bg-emerald-100 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Selesai
                                        </button>
                                    @else
                                        <button type="submit" class="flex items-center gap-1.5 bg-amber-50 border border-amber-300 text-amber-700 text-xs font-bold px-3 py-1.5 rounded-lg hover:bg-amber-100 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                            Undo
                                        </button>
                                    @endif
                                </form>

                                <div class="flex items-center gap-1.5">
                                    <a href="/dashboard/{{ $item->id }}/edit"
                                       class="w-8 h-8 flex items-center justify-center border border-slate-200 rounded-lg text-slate-500 hover:bg-slate-50 hover:text-navy transition-colors" title="Edit">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <button type="button"
                                            onclick="openDeleteModal({{ $item->id }}, '{{ addslashes($item->title) }}')"
                                            class="w-8 h-8 flex items-center justify-center border border-slate-200 rounded-lg text-slate-500 hover:bg-red-50 hover:border-red-300 hover:text-red-600 transition-colors" title="Hapus">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif

</div>

{{-- ═══════════════════════════════════════ ADD MODAL ════════════════════════ --}}
<div id="addModal" class="fixed inset-0 z-50 hidden" aria-modal="true">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('addModal')"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-xl max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between rounded-t-2xl z-10">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Tambah Kegiatan / Proker Baru</h2>
                    <p class="text-xs text-slate-400">Pastikan seluruh progress dan PIC terdata dengan akurat.</p>
                </div>
                <button onclick="closeModal('addModal')" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition-colors">
                    &times;
                </button>
            </div>

            <form method="POST" action="/dashboard" class="px-6 py-5 space-y-4">
                @csrf

                <div>
                    <label class="form-label" for="add_title">Nama Kegiatan / Proker <span class="text-red-500">*</span></label>
                    <input type="text" id="add_title" name="title"
                           value="{{ old('title') }}"
                           placeholder="Min. 4 karakter"
                           class="form-input @error('title') border-red-400 @enderror" required>
                    @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="form-label" for="add_pj">Penanggung Jawab (PIC) <span class="text-red-500">*</span></label>
                        <input type="text" id="add_pj" name="penanggung_jawab"
                               value="{{ old('penanggung_jawab') }}"
                               placeholder="Contoh: Sekbid 4 (Prestasi)"
                               class="form-input @error('penanggung_jawab') border-red-400 @enderror" required>
                    </div>
                    <div>
                        <label class="form-label" for="add_ketupel">Ketua Pelaksana Event</label>
                        <input type="text" id="add_ketupel" name="nama_ketua_pelaksana"
                               value="{{ old('nama_ketua_pelaksana') }}"
                               placeholder="Nama siswa penanggung jawab"
                               class="form-input">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="form-label" for="add_kategori">Kategori Proker <span class="text-red-500">*</span></label>
                        <select id="add_kategori" name="kategori" class="form-input" required>
                            <option value="" disabled selected>Pilih kategori...</option>
                            @foreach(['Program Kerja', 'Regulasi GDS', 'Bimbingan Prestasi', 'Aspirasi MPR'] as $kat)
                                <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label" for="add_bidang">Seksi Bidang Terkait</label>
                        <select id="add_bidang" name="bidang_pic" class="form-input">
                            <option value="0">Umum / Semua Bidang</option>
                            @for($b = 1; $b <= 10; $b++)
                                <option value="{{ $b }}" {{ old('bidang_pic') == $b ? 'selected' : '' }}>Seksi Bidang {{ $b }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="form-label" for="add_kanban">Status Kanban</label>
                        <select id="add_kanban" name="kanban_status" class="form-input">
                            <option value="todo" selected>To Do</option>
                            <option value="inprogress">In Progress</option>
                            <option value="blocked">Blocked</option>
                            <option value="done">Done</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label" for="add_prioritas">Prioritas</label>
                        <select id="add_prioritas" name="prioritas" class="form-input">
                            <option value="rendah">Rendah</option>
                            <option value="normal" selected>Normal</option>
                            <option value="tinggi">Tinggi</option>
                            <option value="kritis">Kritis</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label" for="add_progress">Progress (%)</label>
                        <input type="number" id="add_progress" name="persentase_selesai" min="0" max="100" value="0" class="form-input">
                    </div>
                </div>

                <div>
                    <label class="form-label" for="add_target">Target Selesai <span class="text-red-500">*</span></label>
                    <input type="datetime-local" id="add_target" name="target_selesai"
                           value="{{ old('target_selesai') }}"
                           class="form-input @error('target_selesai') border-red-400 @enderror" required>
                </div>

                <div>
                    <label class="form-label" for="add_evaluasi">Catatan Evaluasi / Notulensi <span class="text-red-500">*</span></label>
                    <textarea id="add_evaluasi" name="catatan_evaluasi" rows="4"
                              placeholder="Min. 15 karakter — tuliskan notulensi rapat dan evaluasi agar kegiatan terdokumentasi..."
                              class="form-input resize-none @error('catatan_evaluasi') border-red-400 @enderror" required>{{ old('catatan_evaluasi') }}</textarea>
                    @error('catatan_evaluasi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeModal('addModal')"
                            class="flex-1 py-2.5 border border-slate-200 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 btn-primary justify-center py-2.5 rounded-xl text-sm font-semibold">
                        Simpan Kegiatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════ DELETE MODAL ══════════════════════ --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden" aria-modal="true">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('deleteModal')"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
            <div class="flex items-center justify-center w-12 h-12 bg-red-100 rounded-xl mx-auto mb-4">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900 text-center mb-2">Hapus Kegiatan?</h3>
            <p class="text-sm text-slate-500 text-center mb-1">Apakah kamu yakin akan menghapus data kegiatan:</p>
            <p id="deleteItemTitle" class="text-sm font-semibold text-slate-800 text-center mb-6 px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg"></p>
            <p class="text-xs text-red-500 text-center mb-6">Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex gap-3">
                <button type="button" onclick="closeModal('deleteModal')"
                        class="flex-1 py-2.5 border border-slate-200 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors">
                    Batal
                </button>
                <form id="deleteForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full btn-danger justify-center py-2.5 rounded-xl text-sm">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal('addModal');
            closeModal('deleteModal');
        }
    });

    function openDeleteModal(id, title) {
        document.getElementById('deleteItemTitle').textContent = title;
        document.getElementById('deleteForm').action = '/dashboard/' + id;
        openModal('deleteModal');
    }
</script>
@endpush
