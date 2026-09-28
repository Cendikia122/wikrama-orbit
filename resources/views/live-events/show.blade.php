@extends('layouts.app')

@section('title', $event->judul ?? 'Detail Event')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- ── Back Link ── --}}
    <a href="/live-events" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-navy transition-colors mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Live Events
    </a>

    @php
        $jenisMap = [
            'pemilu'       => ['label' => 'Pemilu',       'bg' => 'bg-red-100',    'text' => 'text-red-700'],
            'lomba'        => ['label' => 'Lomba',        'bg' => 'bg-purple-100', 'text' => 'text-purple-700'],
            'voting_umum'  => ['label' => 'Voting Umum',  'bg' => 'bg-blue-100',   'text' => 'text-blue-700'],
        ];
        $statusMap = [
            'akan_datang' => ['label' => 'Akan Datang', 'bg' => 'bg-slate-100',   'text' => 'text-slate-600',   'dot' => 'bg-slate-400'],
            'berlangsung' => ['label' => 'Berlangsung', 'bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500'],
            'selesai'     => ['label' => 'Selesai',     'bg' => 'bg-gray-100',    'text' => 'text-gray-500',    'dot' => 'bg-gray-400'],
        ];
        $j = $jenisMap[$event->jenis]   ?? $jenisMap['voting_umum'];
        $s = $statusMap[$event->status] ?? $statusMap['akan_datang'];
        $totalSuara = isset($options) ? $options->sum('jumlah_suara') : 0;
    @endphp

    {{-- ── Event Header ── --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm mb-6">
        <div class="flex items-center gap-2 mb-4">
            <span class="badge {{ $j['bg'] }} {{ $j['text'] }}">{{ $j['label'] }}</span>
            <span class="badge {{ $s['bg'] }} {{ $s['text'] }} flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full {{ $s['dot'] }} {{ $event->status === 'berlangsung' ? 'animate-pulse' : '' }}"></span>
                {{ $s['label'] }}
            </span>
        </div>

        <h1 class="text-xl font-bold text-slate-900 mb-2">{{ $event->judul }}</h1>

        @if($event->deskripsi)
            <p class="text-sm text-slate-600 leading-relaxed mb-4">{{ $event->deskripsi }}</p>
        @endif

        @if($event->mulai_at || $event->selesai_at)
            <div class="flex items-center gap-2 text-xs text-slate-500 bg-slate-50 rounded-lg px-3 py-2">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>
                    {{ $event->mulai_at ? \Carbon\Carbon::parse($event->mulai_at)->translatedFormat('d M Y, H:i') : '–' }}
                    @if($event->selesai_at)
                        &rarr; {{ \Carbon\Carbon::parse($event->selesai_at)->translatedFormat('d M Y, H:i') }}
                    @endif
                </span>
            </div>
        @endif
    </div>

    {{-- ── Voting Section ── --}}
    @if($event->status === 'berlangsung')
        @auth
            @if(!$sudah_vote)
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm mb-6">
                    <h2 class="text-base font-semibold text-slate-800 mb-5 flex items-center gap-2">
                        <svg class="w-4 h-4 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                        Berikan Suaramu
                    </h2>
                    <form method="POST" action="/live-events/{{ $event->id }}/vote" class="space-y-3">
                        @csrf
                        @if(isset($options) && $options->count() > 0)
                            @foreach($options as $option)
                                <label class="flex items-center gap-3 border border-slate-200 rounded-xl px-4 py-3.5 cursor-pointer hover:border-navy hover:bg-navy/5 transition-all has-[:checked]:border-navy has-[:checked]:bg-navy/5"
                                       style="display:flex; align-items:center; gap:0.75rem; border:1.5px solid #e2e8f0; border-radius:0.75rem; padding:0.875rem 1rem; cursor:pointer;">
                                    <input type="radio" name="option_id" value="{{ $option->id }}"
                                           class="w-4 h-4 accent-navy" required>
                                    <span class="text-sm font-medium text-slate-800">{{ $option->nama_kandidat ?? $option->nama }}</span>
                                </label>
                            @endforeach
                        @else
                            <p class="text-sm text-slate-500">Belum ada kandidat yang tersedia.</p>
                        @endif

                        <div class="pt-2">
                            <button type="submit" class="btn-primary w-full justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Berikan Suara
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 rounded-2xl px-5 py-4 mb-6">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-emerald-800">Kamu sudah memilih</p>
                        <p class="text-xs text-emerald-600 mt-0.5">Suaramu telah tercatat. Terima kasih sudah berpartisipasi!</p>
                    </div>
                </div>
            @endif
        @else
            <div class="flex items-center gap-3 bg-amber-50 border border-amber-200 rounded-2xl px-5 py-4 mb-6">
                <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <p class="text-sm text-amber-800">
                    <a href="/login" class="font-semibold underline">Login</a> untuk memberikan suaramu.
                </p>
            </div>
        @endauth
    @endif

    {{-- ── Results Section ── --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm mb-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                <svg class="w-4 h-4 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Perolehan Suara Sementara
            </h2>
            <a href="{{ request()->fullUrl() }}"
               class="inline-flex items-center gap-1.5 text-xs font-semibold text-navy border border-navy/20 bg-navy/5 hover:bg-navy/10 rounded-lg px-3 py-1.5 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Perbarui
            </a>
        </div>

        @if(isset($options) && $options->count() > 0)
            <div class="space-y-4">
                @foreach($options as $option)
                    @php
                        $pct = $totalSuara > 0 ? round(($option->jumlah_suara / $totalSuara) * 100) : 0;
                    @endphp
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-sm font-medium text-slate-800">{{ $option->nama_kandidat ?? $option->nama }}</span>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold text-navy">{{ $pct }}%</span>
                                <span class="text-xs text-slate-400">({{ $option->jumlah_suara }} suara)</span>
                            </div>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5">
                            <div class="bg-navy rounded-full h-2.5 transition-all duration-500"
                                 style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-500">Total suara masuk</span>
                <span class="text-sm font-bold text-slate-900">{{ $totalSuara }}</span>
            </div>
        @else
            <p class="text-sm text-slate-400 text-center py-4">Belum ada perolehan suara.</p>
        @endif
    </div>

    {{-- ── Admin Status Update ── --}}
    @auth
        @if(in_array(Auth::user()->role, ['dewan_harian', 'pembina', 'dewan_penasihat']))
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-base font-semibold text-slate-800 mb-4">Ubah Status Event</h2>
                <form method="POST" action="/live-events/{{ $event->id }}/status" class="flex items-center gap-3">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="form-input max-w-xs">
                        <option value="akan_datang" {{ $event->status === 'akan_datang' ? 'selected' : '' }}>Akan Datang</option>
                        <option value="berlangsung" {{ $event->status === 'berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                        <option value="selesai"     {{ $event->status === 'selesai'     ? 'selected' : '' }}>Selesai</option>
                    </select>
                    <button type="submit" class="btn-primary">Simpan</button>
                </form>
            </div>
        @endif
    @endauth

</div>
@endsection
