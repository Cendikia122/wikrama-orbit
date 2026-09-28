@extends('layouts.app')
@section('title', 'Daftar Akun')

@section('content')
<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">

        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-navy-dark rounded-xl mb-4 shadow-md">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-900">Daftar Akun Warga</h1>
            <p class="text-slate-500 text-sm mt-1">Daftar sebagai Warga Wikrama — gunakan email @smkwikrama.sch.id</p>
        </div>

        {{-- Card --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-6 md:p-8 shadow-sm">

            {{-- Info Banner --}}
            <div class="flex items-start gap-3 bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                <svg class="w-5 h-5 text-blue-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-blue-700 text-sm leading-snug">
                    <span class="font-semibold">Pendaftaran ini untuk Warga Wikrama.</span>
                    Akun Pengurus OSIS-MPR didaftarkan oleh Pembina.
                </p>
            </div>

            <form method="POST" action="/register" class="space-y-5">
                @csrf

                {{-- Nama Lengkap --}}
                <div>
                    <label class="form-label" for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name') }}"
                           placeholder="Nama lengkap kamu (min. 3 karakter)"
                           class="form-input @error('name') border-red-400 focus:ring-red-400 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="form-label" for="email">Email Institusi</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="nama@smkwikrama.sch.id"
                           class="form-input @error('email') border-red-400 focus:ring-red-400 @enderror">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="text-xs text-slate-400 mt-1">Wajib menggunakan email institusi @smkwikrama.sch.id</p>
                </div>

                {{-- Username --}}
                <div>
                    <label class="form-label" for="username">Username</label>
                    <input type="text" id="username" name="username"
                           value="{{ old('username') }}"
                           placeholder="4–8 karakter, unik"
                           maxlength="8"
                           class="form-input @error('username') border-red-400 focus:ring-red-400 @enderror">
                    @error('username')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="text-xs text-slate-400 mt-1">Minimal 4, maksimal 8 karakter.</p>
                </div>

                {{-- Password --}}
                <div>
                    <label class="form-label" for="password">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                               placeholder="8–15 karakter"
                               class="form-input pr-10 @error('password') border-red-400 focus:ring-red-400 @enderror">
                        <button type="button" onclick="togglePwd('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="text-xs text-slate-400 mt-1">Minimal 8, maksimal 15 karakter.</p>
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               placeholder="Ulangi password"
                               class="form-input pr-10">
                        <button type="button" onclick="togglePwd('password_confirmation', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full btn-primary justify-center py-2.5 rounded-xl text-sm font-semibold">
                    Daftar sebagai Warga
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                <p class="text-sm text-slate-500">Sudah punya akun?
                    <a href="/login" class="font-semibold text-navy hover:text-navy-dark transition-colors">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePwd(id, btn) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
@endpush
