@extends('layouts.app')

@section('title', 'Buat Live Event')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- ── Back Link ── --}}
    <a href="/live-events" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-navy transition-colors mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali
    </a>

    {{-- ── Page Header ── --}}
    <div class="flex items-center gap-3 mb-8">
        <div class="w-10 h-10 rounded-xl bg-navy flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4v16m8-8H4"/>
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Buat Live Event</h1>
            <p class="text-sm text-slate-500 mt-0.5">Isi detail event dan kandidat yang akan dipilih.</p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
        <form method="POST" action="/live-events" class="space-y-6">
            @csrf

            {{-- Judul --}}
            <div>
                <label class="form-label" for="judul">Judul Event <span class="text-red-500">*</span></label>
                <input id="judul" name="judul" type="text"
                       class="form-input {{ $errors->has('judul') ? 'border-red-400' : '' }}"
                       placeholder="contoh: Pemilihan Ketua OSIS 2025"
                       value="{{ old('judul') }}" required>
                @error('judul')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jenis --}}
            <div>
                <label class="form-label" for="jenis">Jenis Event <span class="text-red-500">*</span></label>
                <select id="jenis" name="jenis"
                        class="form-input {{ $errors->has('jenis') ? 'border-red-400' : '' }}" required>
                    <option value="" disabled {{ old('jenis') ? '' : 'selected' }}>Pilih jenis...</option>
                    <option value="pemilu"      {{ old('jenis') === 'pemilu'      ? 'selected' : '' }}>Pemilu</option>
                    <option value="lomba"       {{ old('jenis') === 'lomba'       ? 'selected' : '' }}>Lomba</option>
                    <option value="voting_umum" {{ old('jenis') === 'voting_umum' ? 'selected' : '' }}>Voting Umum</option>
                </select>
                @error('jenis')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="form-label" for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4"
                          class="form-input {{ $errors->has('deskripsi') ? 'border-red-400' : '' }}"
                          placeholder="Jelaskan tujuan dan mekanisme event ini...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label" for="mulai_at">Mulai <span class="text-red-500">*</span></label>
                    <input id="mulai_at" name="mulai_at" type="datetime-local"
                           class="form-input {{ $errors->has('mulai_at') ? 'border-red-400' : '' }}"
                           value="{{ old('mulai_at') }}" required>
                    @error('mulai_at')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="form-label" for="selesai_at">Selesai <span class="text-red-500">*</span></label>
                    <input id="selesai_at" name="selesai_at" type="datetime-local"
                           class="form-input {{ $errors->has('selesai_at') ? 'border-red-400' : '' }}"
                           value="{{ old('selesai_at') }}" required>
                    @error('selesai_at')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Kandidat --}}
            <div>
                <div class="flex items-center justify-between mb-3">
                    <label class="form-label" style="margin-bottom:0;">
                        Kandidat / Pilihan <span class="text-red-500">*</span>
                    </label>
                    <button type="button" id="addKandidat"
                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-navy border border-navy/20 bg-navy/5 hover:bg-navy/10 rounded-lg px-3 py-1.5 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Kandidat
                    </button>
                </div>
                <div id="kandidatList" class="space-y-2.5">
                    <div class="kandidat-row flex items-center gap-2">
                        <input type="text" name="kandidat[]"
                               class="form-input"
                               placeholder="Nama kandidat 1" required
                               value="{{ old('kandidat.0') }}">
                        <button type="button" class="remove-kandidat w-8 h-8 rounded-lg border border-slate-200 flex items-center justify-center text-slate-400 hover:text-red-500 hover:border-red-300 transition-colors shrink-0" disabled>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <div class="kandidat-row flex items-center gap-2">
                        <input type="text" name="kandidat[]"
                               class="form-input"
                               placeholder="Nama kandidat 2" required
                               value="{{ old('kandidat.1') }}">
                        <button type="button" class="remove-kandidat w-8 h-8 rounded-lg border border-slate-200 flex items-center justify-center text-slate-400 hover:text-red-500 hover:border-red-300 transition-colors shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
                @error('kandidat')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
                @error('kandidat.*')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-xs text-slate-400">Minimal 2 kandidat diperlukan.</p>
            </div>

            {{-- Submit --}}
            <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                <a href="/live-events" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">Batal</a>
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Buat Event
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        var list = document.getElementById('kandidatList');
        var addBtn = document.getElementById('addKandidat');
        var counter = list.querySelectorAll('.kandidat-row').length;

        function updateRemoveButtons() {
            var rows = list.querySelectorAll('.kandidat-row');
            rows.forEach(function (row, idx) {
                var btn = row.querySelector('.remove-kandidat');
                if (rows.length <= 2) {
                    btn.disabled = true;
                    btn.style.opacity = '0.3';
                    btn.style.cursor = 'not-allowed';
                } else {
                    btn.disabled = false;
                    btn.style.opacity = '1';
                    btn.style.cursor = 'pointer';
                }
            });
        }

        addBtn.addEventListener('click', function () {
            counter++;
            var row = document.createElement('div');
            row.className = 'kandidat-row flex items-center gap-2';
            row.innerHTML =
                '<input type="text" name="kandidat[]" class="form-input" placeholder="Nama kandidat ' + counter + '" required>' +
                '<button type="button" class="remove-kandidat w-8 h-8 rounded-lg border border-slate-200 flex items-center justify-center text-slate-400 hover:text-red-500 hover:border-red-300 transition-colors shrink-0">' +
                '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>' +
                '</button>';
            list.appendChild(row);
            row.querySelector('.remove-kandidat').addEventListener('click', removeRow);
            updateRemoveButtons();
        });

        function removeRow() {
            this.closest('.kandidat-row').remove();
            updateRemoveButtons();
        }

        list.querySelectorAll('.remove-kandidat').forEach(function (btn) {
            btn.addEventListener('click', removeRow);
        });

        updateRemoveButtons();
    })();
</script>
@endpush
