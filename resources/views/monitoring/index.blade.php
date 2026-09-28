@extends('layouts.app')
@section('title', 'Database Anggota OSIS-MPR')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8 flex justify-between items-start">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Database Anggota OSIS-MPR</h1>
            <p class="text-sm text-slate-500 mt-1">Monitoring lengkap seluruh pengurus OSIS-MPR SMKS Wikrama Bogor</p>
        </div>
        @if($canManage)
        <a href="/monitoring/tambah" class="bg-blue-800 hover:bg-blue-900 text-white font-medium px-4 py-2 rounded-lg text-sm">+ Tambah Anggota</a>
        @endif
    </div>

    {{-- Stats Row --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total Anggota Aktif</p>
            <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $total_aktif ?? 0 }}</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total Seluruh</p>
            <p class="text-2xl font-bold text-blue-600 mt-1">{{ $total_anggota ?? 0 }}</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Tidak Hadir GDS</p>
            <p class="text-2xl font-bold text-red-600 mt-1">{{ $total_absen_gds ?? 0 }}</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total Pelanggaran Siswa</p>
            <p class="text-2xl font-bold text-amber-600 mt-1">{{ $total_pelanggaran ?? 0 }}</p>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm mb-6">
        <form method="GET" action="/monitoring" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[200px]">
                <label for="search" class="form-label">Pencarian</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-input" placeholder="Cari nama / jabatan...">
            </div>
            <div class="w-full sm:w-auto">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-input">
                    <option value="">Semua Role</option>
                    <option value="pembina" {{ request('role') == 'pembina' ? 'selected' : '' }}>Pembina</option>
                    <option value="dewan_penasihat" {{ request('role') == 'dewan_penasihat' ? 'selected' : '' }}>Dewan Penasihat</option>
                    <option value="mpr" {{ request('role') == 'mpr' ? 'selected' : '' }}>MPR</option>
                    <option value="dewan_harian" {{ request('role') == 'dewan_harian' ? 'selected' : '' }}>Dewan Harian</option>
                    <option value="koordinator_bidang" {{ request('role') == 'koordinator_bidang' ? 'selected' : '' }}>Koordinator Bidang</option>
                </select>
            </div>
            <div class="w-full sm:w-auto">
                <label for="bidang" class="form-label">Bidang</label>
                <select name="bidang" id="bidang" class="form-input">
                    <option value="">Semua Bidang</option>
                    @for($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}" {{ request('bidang') == $i ? 'selected' : '' }}>Bidang {{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="w-full sm:w-auto">
                <label for="is_aktif" class="form-label">Status</label>
                <select name="is_aktif" id="is_aktif" class="form-input">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_aktif') == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('is_aktif') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div class="flex gap-2 w-full sm:w-auto mt-4 sm:mt-0">
                <button type="submit" class="btn-primary w-full sm:w-auto justify-center">Filter</button>
                <a href="/monitoring" class="btn-primary bg-slate-500 hover:bg-slate-600 w-full sm:w-auto justify-center" style="background-color: #64748b;">Reset</a>
            </div>
        </form>
    </div>

    {{-- Data Table --}}
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Username</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Jabatan</th>
                        <th class="px-6 py-4">Bidang</th>
                        <th class="px-6 py-4">Angkatan</th>
                        <th class="px-6 py-4">Periode</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($anggota ?? [] as $index => $a)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $a->name }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $a->username }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $roleColors = [
                                        'pembina' => 'bg-navy-light text-white',
                                        'dewan_penasihat' => 'bg-blue-100 text-blue-800',
                                        'mpr' => 'bg-emerald-100 text-emerald-800',
                                        'dewan_harian' => 'bg-purple-100 text-purple-800',
                                        'koordinator_bidang' => 'bg-orange-100 text-orange-800',
                                    ];
                                    $color = $roleColors[$a->role] ?? 'bg-slate-100 text-slate-800';
                                @endphp
                                <span class="badge {{ $color }}">{{ str_replace('_', ' ', Str::title($a->role)) }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $a->jabatan ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $a->bidang > 0 ? 'Bid. ' . $a->bidang : '-' }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $a->angkatan ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $a->periode ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($a->is_aktif ?? true)
                                    <span class="badge bg-emerald-100 text-emerald-800">Aktif</span>
                                @else
                                    <span class="badge bg-red-100 text-red-800">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                @if($canManage)
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Edit -->
                                    <a href="/monitoring/{{ $a->id }}/edit" class="text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 px-2 py-1 rounded font-medium">Edit</a>
                                    
                                    <!-- Toggle Aktif/Nonaktif -->
                                    <form method="POST" action="/monitoring/{{ $a->id }}/toggle" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" onclick="return confirm('{{ $a->is_aktif ? 'Nonaktifkan' : 'Aktifkan' }} anggota ini?')"
                                            class="text-xs px-2 py-1 rounded font-medium {{ $a->is_aktif ? 'bg-amber-50 hover:bg-amber-100 text-amber-700' : 'bg-green-50 hover:bg-green-100 text-green-700' }}">
                                            {{ $a->is_aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>

                                    <!-- Reset Password -->
                                    <form method="POST" action="/monitoring/{{ $a->id }}/reset-password" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" onclick="return confirm('Reset password ' + '{{ $a->name }}' + ' ke wikrama2025?')"
                                            class="text-xs bg-slate-50 hover:bg-slate-100 text-slate-600 px-2 py-1 rounded font-medium">Reset PW</button>
                                    </form>

                                    <!-- Delete (pembina/DP only) -->
                                    @if(in_array(Auth::user()->role, ['pembina','dewan_penasihat']))
                                    <form method="POST" action="/monitoring/{{ $a->id }}" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('HAPUS PERMANEN {{ $a->name }}? Data tidak bisa dikembalikan!')"
                                            class="text-xs bg-red-50 hover:bg-red-100 text-red-600 px-2 py-1 rounded font-medium">Hapus</button>
                                    </form>
                                    @endif
                                </div>
                                @else
                                <span class="text-xs text-slate-400">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-slate-500">
                                Tidak ada data anggota ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="flex justify-between mt-4">
        <p class="text-xs text-slate-400">* Password default anggota baru: <code>wikrama2025</code>. Anggota bisa ganti sendiri via menu Ganti Password.</p>
        <p class="text-xs text-slate-400 text-right">Gunakan Ctrl+P untuk mencetak tabel ini</p>
    </div>
</div>
@endsection
