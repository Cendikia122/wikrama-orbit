{{-- Reusable profile card partial --}}
{{-- Usage: @include('organisasi._profile_card', ['member' => $m, 'accent' => 'emerald|navy|slate']) --}}
@php
    $accentMap = [
        'emerald' => ['ring' => 'ring-2 ring-emerald-200', 'bg' => 'bg-emerald-100', 'text' => 'text-emerald-800'],
        'navy'    => ['ring' => 'ring-2 ring-blue-200',    'bg' => 'bg-navy/10',     'text' => 'text-navy'],
        'slate'   => ['ring' => '',                        'bg' => 'bg-slate-100',   'text' => 'text-slate-600'],
    ];
    $ac = $accentMap[$accent ?? 'slate'];
@endphp
<div class="bg-white border border-slate-200 rounded-2xl p-4 text-center shadow-sm w-36 shrink-0">
    <div class="w-12 h-12 rounded-full {{ $ac['bg'] }} {{ $ac['ring'] }} flex items-center justify-center {{ $ac['text'] }} font-bold text-lg mx-auto mb-2">
        {{ strtoupper(substr($member->name ?? $member->nama ?? '?', 0, 1)) }}
    </div>
    <p class="text-xs font-semibold text-slate-900 leading-snug">{{ $member->name ?? $member->nama }}</p>
    @if(isset($member->jabatan) && $member->jabatan)
        <p class="text-xs text-slate-500 mt-0.5">{{ $member->jabatan }}</p>
    @endif
    @if(isset($member->angkatan) && $member->angkatan)
        <span class="badge bg-slate-100 text-slate-500 mt-1.5 text-xs">Angk. {{ $member->angkatan }}</span>
    @endif
</div>
