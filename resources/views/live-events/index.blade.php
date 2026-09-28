@extends('layouts.app')

@section('title', 'Live Events OSIS')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- ── Page Header ── --}}
    <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-navy flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Live Events OSIS</h1>
                <p class="text-sm text-slate-500 mt-0.5">Pemilu, lomba, dan voting resmi OSIS Wikrama.</p>
            </div>
        </div>

        @auth
            @if(in_array(Auth::user()->role, ['dewan_harian', 'pembina', 'dewan_penasihat', 'koordinator_bidang']))
                <a href="/live-events/create" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Buat Event
                </a>
            @endif
        @endauth
    </div>

    {{-- ── Events Grid ── --}}
    @if(isset($events) && $events->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($events as $event)
                @php
                    $jenisMap = [
                        'pemilu'       => ['label' => 'Pemilu',        'bg' => 'bg-red-100',    'text' => 'text-red-700'],
                        'lomba'        => ['label' => 'Lomba',         'bg' => 'bg-purple-100', 'text' => 'text-purple-700'],
                        'voting_umum'  => ['label' => 'Voting Umum',   'bg' => 'bg-blue-100',   'text' => 'text-blue-700'],
                    ];
                    $statusMap = [
                        'akan_datang'  => ['label' => 'Akan Datang',  'bg' => 'bg-slate-100',   'text' => 'text-slate-600',   'dot' => 'bg-slate-400'],
                        'berlangsung'  => ['label' => 'Berlangsung',  'bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500'],
                        'selesai'      => ['label' => 'Selesai',      'bg' => 'bg-gray-100',    'text' => 'text-gray-500',    'dot' => 'bg-gray-400'],
                    ];
                    $j = $jenisMap[$event->jenis]   ?? $jenisMap['voting_umum'];
                    $s = $statusMap[$event->status] ?? $statusMap['akan_datang'];
                @endphp
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-all flex flex-col">
                    {{-- Top badges --}}
                    <div class="flex items-center gap-2 mb-3">
                        <span class="badge {{ $j['bg'] }} {{ $j['text'] }}">{{ $j['label'] }}</span>
                        <span class="badge {{ $s['bg'] }} {{ $s['text'] }} flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full {{ $s['dot'] }} {{ $event->status === 'berlangsung' ? 'animate-pulse' : '' }}"></span>
                            {{ $s['label'] }}
                        </span>
                    </div>

                    {{-- Title --}}
                    <h2 class="text-base font-semibold text-slate-900 leading-snug mb-2">{{ $event->judul }}</h2>

                    {{-- Dates --}}
                    @if($event->mulai_at || $event->selesai_at)
                        <div class="flex items-center gap-1.5 text-xs text-slate-500 mb-4">
                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                    <div class="mt-auto">
                        <a href="/live-events/{{ $event->id }}" class="btn-primary w-full justify-center">
                            Lihat Detail &amp; Vote
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if(method_exists($events, 'links'))
            <div class="mt-8">{{ $events->links() }}</div>
        @endif
    @else
        <div class="bg-white border border-dashed border-slate-300 rounded-2xl p-16 text-center">
            <svg class="w-12 h-12 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-sm font-semibold text-slate-500">Belum ada event yang tersedia</p>
            <p class="text-xs text-slate-400 mt-1">Event akan muncul di sini saat dibuat oleh pengurus.</p>
            @auth
                @if(in_array(Auth::user()->role, ['dh', 'pembina', 'koorbid']))
                    <a href="/live-events/create" class="btn-primary mt-5 inline-flex">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat Event Pertama
                    </a>
                @endif
            @endauth
        </div>
    @endif

</div>
@endsection
