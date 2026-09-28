<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'WIKRAMA-ORBIT' }} – SMKS Wikrama Bogor</title>

    {{-- Google Font: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        navy:    { DEFAULT: '#1E3A8A', dark: '#0F172A', light: '#3B82F6' },
                        emerald: { DEFAULT: '#059669', light: '#D1FAE5', dark: '#065F46' },
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }

        /* ── Reusable component classes (plain CSS — CDN Tailwind doesn't support @apply) ── */
        .nav-link {
            color: #475569; font-size: 0.875rem; font-weight: 500;
            transition: color 0.15s ease;
        }
        .nav-link:hover { color: #1E3A8A; }

        .btn-primary {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background-color: #1E3A8A; color: #fff; font-size: 0.875rem;
            font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem;
            transition: background-color 0.15s ease; text-decoration: none;
        }
        .btn-primary:hover { background-color: #0F172A; }

        .btn-danger {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background-color: #dc2626; color: #fff; font-size: 0.875rem;
            font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem;
            transition: background-color 0.15s ease;
        }
        .btn-danger:hover { background-color: #b91c1c; }

        .form-input {
            display: block; width: 100%;
            border: 1.5px solid #cbd5e1;
            border-radius: 0.5rem;
            padding: 0.625rem 0.75rem;
            font-size: 0.875rem; color: #1e293b;
            background-color: #fff;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
            box-sizing: border-box;
        }
        .form-input::placeholder { color: #94a3b8; }
        .form-input:focus {
            border-color: #1E3A8A;
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.12);
        }
        .form-input.border-red-400 { border-color: #f87171; }
        .form-input.border-red-400:focus { box-shadow: 0 0 0 3px rgba(248, 113, 113, 0.2); }
        select.form-input { appearance: none; -webkit-appearance: none; cursor: pointer; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem; padding-right: 2.5rem; }
        textarea.form-input { resize: vertical; }

        .form-label {
            display: block; font-size: 0.875rem; font-weight: 500;
            color: #334155; margin-bottom: 0.375rem;
        }

        .badge {
            display: inline-flex; align-items: center;
            font-size: 0.75rem; font-weight: 600;
            padding: 0.2rem 0.6rem; border-radius: 9999px;
        }
    </style>

    @stack('head')
</head>
<body class="min-h-screen flex flex-col text-slate-800 antialiased">

{{-- ═══════════════════════════════════════ TOP NAVBAR ═══════════════════════ --}}
<header class="sticky top-0 z-50 bg-white border-b border-slate-200">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">

        {{-- Brand --}}
        <a href="/" class="flex items-center gap-2.5 shrink-0">
            <div class="bg-navy-dark rounded-lg p-1.5">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div class="leading-none">
                <span class="font-bold text-navy-dark tracking-wide text-sm">WIKRAMA-ORBIT</span>
                <p class="text-xs text-slate-400 font-normal">SMKS Wikrama Bogor</p>
            </div>
        </a>

        {{-- Public Nav Links (desktop) --}}
        <div class="hidden md:flex items-center gap-6">
            <a href="/" class="nav-link">Beranda</a>
            <a href="/organisasi" class="nav-link">Struktur Organisasi</a>
            <a href="/aspirasi" class="nav-link">Aspirasi MPR</a>
            <a href="/live-events" class="nav-link">Live Event</a>
            <a href="/piket" class="nav-link">Jadwal Piket GDS</a>
            @auth
                @if(Auth::user()->role != 'warga')
                    <a href="/monitoring" class="nav-link">Monitoring</a>
                @endif
            @endauth
        </div>

        {{-- Auth Controls --}}
        <div class="flex items-center gap-3">
            @guest
                <a href="/login" class="text-sm font-medium text-slate-600 hover:text-navy transition-colors">Masuk</a>
                <a href="/register" class="btn-primary" style="font-size:0.75rem;padding:0.375rem 0.75rem;">Daftar</a>
            @endguest

            @auth
                {{-- User Dropdown --}}
                <div class="relative" id="userDropdown">
                    <button onclick="toggleDropdown()" class="flex items-center gap-2.5 bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm hover:bg-slate-100 transition-colors">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold"
                             style="background-color:#1E3A8A;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="text-left hidden sm:block">
                            <p class="text-xs font-semibold text-slate-800 leading-none">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-400 mt-0.5 leading-none">
                                {{ Auth::user()->jabatan ?? \Illuminate\Support\Str::title(str_replace('_', ' ', Auth::user()->role)) }}
                            </p>
                        </div>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div id="dropdownMenu" class="hidden absolute right-0 mt-2 bg-white border border-slate-200 rounded-xl shadow-lg overflow-hidden z-50" style="width:220px;">
                        {{-- User Info --}}
                        <div class="px-4 py-3 border-b border-slate-100">
                            <p class="text-xs font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ Auth::user()->email }}</p>
                            @php
                                $roleLabels = [
                                    'pembina'           => ['Pembina OSIS', '#0F172A', '#E2E8F0'],
                                    'dewan_penasihat'   => ['Dewan Penasihat', '#6D28D9', '#EDE9FE'],
                                    'mpr'               => ['MPR', '#B45309', '#FEF3C7'],
                                    'dewan_harian'      => ['Dewan Harian', '#1E3A8A', '#DBEAFE'],
                                    'koordinator_bidang'=> ['Koordinator Bidang', '#065F46', '#D1FAE5'],
                                    'warga'             => ['Warga Wikrama', '#475569', '#F1F5F9'],
                                ];
                                [$rl, $rc, $rbg] = $roleLabels[Auth::user()->role] ?? ['Pengguna', '#475569', '#F1F5F9'];
                            @endphp
                            <span class="badge mt-1.5" style="background:{{ $rbg }};color:{{ $rc }};border:1px solid {{ $rc }}20;">
                                {{ $rl }}
                            </span>
                        </div>

                        {{-- Nav Items --}}
                        <div class="py-1">
                            {{-- Dashboard (org members only) --}}
                            @if(Auth::user()->role !== 'warga')
                            <a href="/dashboard" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/></svg>
                                Dashboard Proker
                            </a>
                            @endif

                            {{-- Keuangan — DH/Pembina only --}}
                            @if(in_array(Auth::user()->role, ['pembina','dewan_penasihat','dewan_harian']))
                            <a href="/keuangan" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Keuangan OSIS
                            </a>
                            @endif

                            {{-- Jadwal Piket --}}
                            <a href="/piket/my-schedule" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Jadwal Piketku
                            </a>

                            @if(in_array(Auth::user()->role, ['pembina','dewan_penasihat','mpr','dewan_harian','koordinator_bidang']))
                            <a href="/piket/absensi" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Absensi GDS
                            </a>
                            <a href="/piket/pelanggaran" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                Catat Pelanggaran
                            </a>
                            @endif

                            <a href="/change-password" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                Ubah Password
                            </a>

                            <div class="border-t border-slate-100 mt-1 pt-1">
                                <form method="POST" action="/logout">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors text-left">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </nav>
</header>

{{-- ═══════════════════════════════════════ FLASH MESSAGES ═══════════════════ --}}
@if(session('success'))
<div id="flash-success" class="bg-emerald-50 border-b border-emerald-200 px-4 py-3">
    <div class="max-w-7xl mx-auto flex items-center gap-2.5">
        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <p class="text-sm text-emerald-800 font-medium">{{ session('success') }}</p>
        <button onclick="document.getElementById('flash-success').remove()" class="ml-auto text-emerald-500 hover:text-emerald-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
</div>
@endif

@if(session('error') || $errors->any())
<div id="flash-error" class="bg-red-50 border-b border-red-200 px-4 py-3">
    <div class="max-w-7xl mx-auto flex items-center gap-2.5">
        <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="text-sm text-red-800 font-medium">
            @if(session('error'))
                {{ session('error') }}
            @else
                Terdapat kesalahan pada formulir. Silakan periksa kembali.
            @endif
        </p>
        <button onclick="document.getElementById('flash-error').remove()" class="ml-auto text-red-500 hover:text-red-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
</div>
@endif

{{-- ═══════════════════════════════════════ MAIN CONTENT ══════════════════════ --}}
<main class="flex-1">
    @yield('content')
</main>

{{-- ═══════════════════════════════════════ FOOTER ════════════════════════════ --}}
<footer class="border-t border-slate-200 bg-white mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-2">
            <div class="bg-navy-dark rounded-md p-1">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <span class="text-sm font-semibold text-slate-700">WIKRAMA-ORBIT</span>
        </div>
        <p class="text-xs text-slate-400 text-center">Platform Manajemen Organisasi, Regulasi GDS & Bimbingan Prestasi — SMKS Wikrama Bogor &copy; {{ date('Y') }}</p>
        <p class="text-xs text-slate-400">Dibangun dengan Laravel &amp; Tailwind CSS</p>
    </div>
</footer>

{{-- ═══════════════════════════════════════ GLOBAL SCRIPTS ════════════════════ --}}
<script>
    function toggleDropdown() {
        const menu = document.getElementById('dropdownMenu');
        menu.classList.toggle('hidden');
    }
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('userDropdown');
        if (dropdown && !dropdown.contains(e.target)) {
            document.getElementById('dropdownMenu')?.classList.add('hidden');
        }
    });
</script>

@stack('scripts')
</body>
</html>
