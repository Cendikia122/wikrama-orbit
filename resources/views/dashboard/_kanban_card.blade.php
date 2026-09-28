@php
    $isOverdue = $item->target_selesai < now() && $item->status == 0;
    $prioBadge = match($item->prioritas) {
        'kritis' => 'bg-red-500 text-white font-bold',
        'tinggi' => 'bg-orange-100 text-orange-800 border-orange-300 font-bold',
        'rendah' => 'bg-slate-100 text-slate-600',
        default  => 'bg-blue-50 text-blue-700 border-blue-200',
    };
@endphp

<div class="bg-white border {{ $isOverdue ? 'border-red-300' : 'border-slate-200' }} rounded-xl p-4 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
    <div>
        {{-- Header tags --}}
        <div class="flex items-center justify-between gap-1.5 mb-2">
            <span class="badge border {{ $prioBadge }} text-[10px]">
                {{ ucfirst($item->prioritas ?? 'normal') }}
            </span>
            @if($item->bidang_pic)
                <span class="badge bg-slate-100 text-slate-700 border border-slate-200 text-[10px]">
                    Sekbid {{ $item->bidang_pic }}
                </span>
            @endif
        </div>

        {{-- Title --}}
        <h4 class="text-xs font-bold text-slate-900 leading-snug mb-1.5 {{ $item->status ? 'line-through text-slate-400' : '' }}">
            {{ $item->title }}
        </h4>

        {{-- Target Date & Overdue --}}
        <div class="text-[11px] text-slate-500 mb-2.5 flex items-center gap-1.5 flex-wrap">
            <span class="{{ $isOverdue ? 'text-red-600 font-bold' : '' }}">
                📅 {{ \Carbon\Carbon::parse($item->target_selesai)->format('d M, H:i') }}
            </span>
            @if($isOverdue)
                <span class="badge bg-red-100 text-red-700 text-[10px] font-bold">Lewat!</span>
            @endif
        </div>

        {{-- PIC & Ketupel --}}
        <div class="text-[11px] text-slate-500 mb-3 space-y-0.5 bg-slate-50 rounded-lg p-2 border border-slate-100">
            <p><span class="font-semibold text-slate-700">PIC:</span> {{ $item->penanggung_jawab }}</p>
            @if($item->nama_ketua_pelaksana)
                <p><span class="font-semibold text-slate-700">Ketupel:</span> {{ $item->nama_ketua_pelaksana }}</p>
            @endif
        </div>

        {{-- Progress Bar --}}
        <div class="mb-3">
            <div class="flex items-center justify-between text-[11px] text-slate-500 mb-1">
                <span>Progress</span>
                <span class="font-bold text-slate-800">{{ $item->persentase_selesai ?? ($item->status ? 100 : 0) }}%</span>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden border border-slate-200">
                <div class="h-1.5 rounded-full transition-all duration-300 {{ $item->status ? 'bg-emerald-600' : 'bg-navy' }}"
                     style="width: {{ $item->persentase_selesai ?? ($item->status ? 100 : 0) }}%"></div>
            </div>
        </div>

        {{-- Catatan Evaluasi --}}
        <p class="text-[11px] text-slate-500 line-clamp-2 italic mb-3">
            "{{ $item->catatan_evaluasi }}"
        </p>
    </div>

    {{-- Footer Actions --}}
    <div class="pt-2.5 border-t border-slate-100 space-y-2">
        {{-- Quick Move Form --}}
        <form method="POST" action="/dashboard/{{ $item->id }}/kanban" class="flex items-center gap-1.5">
            @csrf
            @method('PATCH')
            <select name="kanban_status" onchange="this.form.submit()"
                    class="form-input text-[11px] py-1 px-2 rounded-lg bg-slate-50 text-slate-700 border-slate-200">
                <option value="todo" {{ $item->kanban_status === 'todo' ? 'selected' : '' }}>&rarr; To Do</option>
                <option value="inprogress" {{ $item->kanban_status === 'inprogress' ? 'selected' : '' }}>&rarr; In Progress</option>
                <option value="blocked" {{ $item->kanban_status === 'blocked' ? 'selected' : '' }}>&rarr; Blocked</option>
                <option value="done" {{ ($item->kanban_status === 'done' || $item->status == 1) ? 'selected' : '' }}>&rarr; Done</option>
            </select>
        </form>

        <div class="flex items-center justify-between text-xs pt-1">
            <a href="/dashboard/{{ $item->id }}/edit" class="text-slate-500 hover:text-navy text-[11px] font-semibold">
                Edit Detail &rarr;
            </a>
            <button type="button"
                    onclick="openDeleteModal({{ $item->id }}, '{{ addslashes($item->title) }}')"
                    class="text-red-400 hover:text-red-600 text-[11px]">
                Hapus
            </button>
        </div>
    </div>
</div>
