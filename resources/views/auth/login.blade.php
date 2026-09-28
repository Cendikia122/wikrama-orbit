@extends('layouts.app')
@section('title', 'Masuk')

@section('content')
<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">

        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-navy-dark rounded-xl mb-4 shadow-md">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-900">Masuk ke WIKRAMA-ORBIT</h1>
            <p class="text-slate-500 text-sm mt-1">Portal resmi pengurus OSIS-MPR Wikrama Bogor</p>
        </div>

        {{-- Card --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-6 md:p-8 shadow-sm">
            <form method="POST" action="/login" class="space-y-5">
                @csrf

                {{-- Username --}}
                <div>
                    <label class="form-label" for="username">Username</label>
                    <input type="text" id="username" name="username"
                           value="{{ old('username') }}"
                           placeholder="Masukkan username kamu"
                           class="form-input @error('username') border-red-400 focus:ring-red-400 @enderror"
                           autocomplete="username">
                    @error('username')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="form-label" for="password">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                               placeholder="Masukkan password"
                               class="form-input pr-10 @error('password') border-red-400 focus:ring-red-400 @enderror"
                               autocomplete="current-password">
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
                </div>

                <button type="submit" class="w-full btn-primary justify-center py-2.5 rounded-xl text-sm font-semibold">
                    Masuk ke Dashboard
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                <p class="text-sm text-slate-500">Belum punya akun?
                    <a href="/register" class="font-semibold text-navy hover:text-navy-dark transition-colors">Daftar di sini</a>
                </p>
            </div>
        </div>

        {{-- Demo Credentials --}}
        <div class="mt-4 bg-slate-50 border border-slate-200 rounded-xl p-4">
            <p class="text-xs font-semibold text-slate-600 mb-2">💡 Akun Demo:</p>
            <div class="space-y-1 text-xs text-slate-500">
                <p>Pembina → username: <code class="bg-white border border-slate-200 px-1.5 py-0.5 rounded text-xs">rizal</code> / pass: <code class="bg-white border border-slate-200 px-1.5 py-0.5 rounded text-xs">password123</code></p>
                <p>Pengurus → username: <code class="bg-white border border-slate-200 px-1.5 py-0.5 rounded text-xs">ketua2</code> / pass: <code class="bg-white border border-slate-200 px-1.5 py-0.5 rounded text-xs">password123</code></p>
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
