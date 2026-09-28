@extends('layouts.app')
@section('title', 'Aspirasi MPR Wikrama')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- ── Page Header ── --}}
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 rounded-xl bg-navy flex items-center justify-center shrink-0" style="background:#1E3A8A;">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3v-3z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Aspirasi MPR Wikrama</h1>
                <p class="text-sm text-slate-500 mt-0.5">Sampaikan aspirasimu — dibaca langsung oleh MPR dan dipublikasikan secara transparan.</p>
            </div>
        </div>
    </div>

    {{-- ── Google Form Info Banner ── --}}
    <div class="flex items-start gap-3 bg-blue-50 border border-blue-200 rounded-xl px-4 py-3 mb-8 text-sm text-blue-800">
        <svg class="w-4 h-4 mt-0.5 shrink-0 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>
            Tidak ingin login?
            <a href="https://forms.gle/contoh" target="_blank" rel="noopener"
               class="font-semibold underline underline-offset-2 hover:text-blue-600 transition-colors">
                Sampaikan via Google Form (tanpa login)
            </a>
        </span>
    </div>

    {{-- ── Submit Form / Login Prompt ── --}}
    @auth
        <div class="bg-white border border-slate-200 rounded-2xl p-6 mb-10 shadow-sm">
            <h2 class="text-base font-semibold text-slate-800 mb-5 flex items-center gap-2">
                <svg class="w-4 h-4 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                Tulis Aspirasi Baru
            </h2>
            <form method="POST" action="/aspirasi" class="space-y-4">
                @csrf
                <div>
                    <label class="form-label" for="judul">Judul Aspirasi <span class="text-red-500">*</span></label>
                    <input id="judul" name="judul" type="text" class="form-input @error('judul') border-red-400 @enderror"
                           placeholder="Singkat dan jelas" value="{{ old('judul') }}" required>
                    @error('judul')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="form-label" for="isi">Isi Aspirasi <span class="text-red-500">*</span></label>
                    <textarea id="isi" name="isi" rows="4"
                              class="form-input @error('isi') border-red-400 @enderror"
                              placeholder="Jelaskan aspirasimu secara detail..." minlength="20" required>{{ old('isi') }}</textarea>
                    @error('isi')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-slate-400">Minimal 20 karakter.</p>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Sampaikan ke MPR
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="bg-white border border-slate-200 rounded-2xl p-6 mb-10 flex items-center justify-between gap-4 flex-wrap">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-800">Login untuk menyampaikan aspirasi</p>
                    <p class="text-xs text-slate-500 mt-0.5">Warga Wikrama dapat login menggunakan email @smkwikrama.sch.id.</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="/login" class="btn-primary text-xs px-4 py-2">Masuk</a>
                <a href="/register" class="px-4 py-2 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">Daftar Warga</a>
            </div>
        </div>
    @endauth

    {{-- ── Public Aspirasi List ── --}}
    <div class="mb-4 flex items-center justify-between">
        <h2 class="text-base font-semibold text-slate-800">Aspirasi Masuk</h2>
        <span class="text-xs text-slate-400">{{ $aspirasi->total() }} aspirasi</span>
    </div>

    @if($aspirasi->count() > 0)
        <div class="space-y-4">
            @foreach($aspirasi as $item)
                @php
                    $statusMap = [
                        'menunggu'  => ['label' => 'Menunggu', 'bg' => 'bg-amber-100',   'text' => 'text-amber-800'],
                        'diproses'  => ['label' => 'Diproses', 'bg' => 'bg-blue-100',    'text' => 'text-blue-800'],
                        'selesai'   => ['label' => 'Selesai',  'bg' => 'bg-emerald-100', 'text' => 'text-emerald-800'],
                    ];
                    $s = $statusMap[$item->status] ?? $statusMap['menunggu'];
                    $canRespond = Auth::check() && in_array(Auth::user()->role, ['pembina','dewan_penasihat','mpr','dewan_harian']);
                @endphp
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <h3 class="text-sm font-bold text-slate-900 leading-snug">{{ $item->judul }}</h3>
                        <span class="badge {{ $s['bg'] }} {{ $s['text'] }} shrink-0 text-xs">{{ $s['label'] }}</span>
                    </div>

                    {{-- Isi aspirasi --}}
                    <p class="text-sm text-slate-600 leading-relaxed">
                        {{ $item->isi }}
                    </p>

                    {{-- Meta (FLAT TABLE - NO JOIN/RELATION) --}}
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center gap-3 flex-wrap text-xs text-slate-500">
                        <div class="flex items-center gap-1.5">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center text-white text-xs font-bold" style="background:#1E3A8A;">
                                {{ strtoupper(substr($item->nama_pengirim, 0, 1)) }}
                            </div>
                            <span class="font-semibold text-slate-700">{{ $item->nama_pengirim }}</span>
                        </div>
                        <span class="badge bg-slate-100 text-slate-600">{{ ucfirst(str_replace('_', ' ', $item->role_pengirim)) }}</span>
                        <span class="text-slate-400 ml-auto">
                            {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                        </span>

                        @if($canRespond)
                            <button onclick="document.getElementById('respondModal-{{ $item->id }}').classList.remove('hidden')"
                                    class="text-xs font-semibold text-navy hover:underline">
                                Beri Tanggapan
                            </button>
                        @endif
                    </div>

                    {{-- Tanggapan MPR --}}
                    @if(!empty($item->tanggapan))
                        <div class="mt-4 border-l-4 border-emerald-500 bg-emerald-50 rounded-r-xl px-4 py-3">
                            <p class="text-xs font-bold text-emerald-800 mb-1 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Tanggapan Resmi MPR Wikrama:
                            </p>
                            <p class="text-xs text-emerald-900 leading-relaxed">{{ $item->tanggapan }}</p>
                        </div>
                    @endif
                </div>

                {{-- Modal Tanggapan (for MPR/DH/Pembina) --}}
                @if($canRespond)
                    <div id="respondModal-{{ $item->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4" style="background: rgba(15,23,42,0.5);">
                        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-base font-bold text-slate-900">Tanggapi Aspirasi: {{ $item->judul }}</h3>
                                <button onclick="document.getElementById('respondModal-{{ $item->id }}').classList.add('hidden')"
                                        class="w-7 h-7 rounded-lg border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-700">
                                    &times;
                                </button>
                            </div>
                            <form method="POST" action="/aspirasi/{{ $item->id }}" class="space-y-4">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <label class="form-label" for="status-{{ $item->id }}">Status Tindak Lanjut</label>
                                    <select id="status-{{ $item->id }}" name="status" class="form-input" required>
                                        <option value="menunggu" {{ $item->status === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="diproses" {{ $item->status === 'diproses' ? 'selected' : '' }}>Diproses (Sedang Dibahas)</option>
                                        <option value="selesai" {{ $item->status === 'selesai' ? 'selected' : '' }}>Selesai (Sudah Ditindaklanjuti)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label" for="tanggapan-{{ $item->id }}">Tanggapan Resmi MPR</label>
                                    <textarea id="tanggapan-{{ $item->id }}" name="tanggapan" rows="4" class="form-input"
                                              placeholder="Tuliskan jawaban resmi dari pihak MPR...">{{ old('tanggapan', $item->tanggapan) }}</textarea>
                                </div>
                                <div class="flex justify-end gap-2 pt-2">
                                    <button type="button"
                                            onclick="document.getElementById('respondModal-{{ $item->id }}').classList.add('hidden')"
                                            class="px-4 py-2 border border-slate-200 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-50">
                                        Batal
                                    </button>
                                    <button type="submit" class="btn-primary text-xs px-4 py-2">
                                        Simpan Tanggapan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $aspirasi->links() }}
        </div>
    @else
        <div class="bg-white border border-dashed border-slate-300 rounded-2xl p-12 text-center">
            <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p class="text-sm font-medium text-slate-500">Belum ada aspirasi yang masuk</p>
            <p class="text-xs text-slate-400 mt-1">Jadilah yang pertama menyampaikan aspirasimu.</p>
        </div>
    @endif

</div>
@endsection
