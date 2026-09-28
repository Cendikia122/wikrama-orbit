@extends('layouts.app')
@section('title', 'Ubah Password')

@section('content')
<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">

        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-navy-dark rounded-xl mb-4 shadow-md">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-900">Ubah Password</h1>
            <p class="text-slate-500 text-sm mt-1">Perbarui kata sandi akun WIKRAMA-ORBIT kamu</p>
        </div>

        {{-- Card --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-6 md:p-8 shadow-sm">

            {{-- User info banner --}}
            <div class="flex items-center gap-3 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 mb-6">
                <div class="w-9 h-9 bg-navy rounded-full flex items-center justify-center text-white text-sm font-bold shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-400">&#64;{{ Auth::user()->username }}</p>
                </div>
            </div>

            <form method="POST" action="/change-password" class="space-y-5">
                @csrf

                {{-- Password Saat Ini --}}
                <div>
                    <label class="form-label" for="password_kini">Password Saat Ini</label>
                    <div class="relative">
                        <input type="password" id="password_kini" name="password_kini"
                               placeholder="Masukkan password saat ini"
                               class="form-input pr-10 @error('password_kini') border-red-400 focus:ring-red-400 @enderror">
                        <button type="button" onclick="togglePwd('password_kini')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                    @error('password_kini')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="border-t border-slate-100 pt-5">
                    {{-- Password Baru --}}
                    <div class="mb-5">
                        <label class="form-label" for="password_baru">Password Baru</label>
                        <div class="relative">
                            <input type="password" id="password_baru" name="password_baru"
                                   placeholder="8–15 karakter"
                                   class="form-input pr-10 @error('password_baru') border-red-400 focus:ring-red-400 @enderror">
                            <button type="button" onclick="togglePwd('password_baru')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                        @error('password_baru')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-slate-400 mt-1">Minimal 8, maksimal 15 karakter.</p>
                    </div>

                    {{-- Konfirmasi Password Baru --}}
                    <div>
                        <label class="form-label" for="password_baru_confirmation">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input type="password" id="password_baru_confirmation" name="password_baru_confirmation"
                                   placeholder="Ulangi password baru"
                                   class="form-input pr-10">
                            <button type="button" onclick="togglePwd('password_baru_confirmation')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <a href="/dashboard" class="flex-1 text-center py-2.5 border border-slate-200 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 btn-primary justify-center py-2.5 rounded-xl text-sm font-semibold">
                        Simpan Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePwd(id) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
@endpush
