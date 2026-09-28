@extends('layouts.app')
@section('title', 'Laporan Keuangan OSIS')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- ── Header ── --}}
    <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background:#1E3A8A;">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Keuangan Kas OSIS</h1>
                <p class="text-sm text-slate-500 mt-0.5">Pencatatan pemasukan & pengeluaran kas OSIS Wikrama (Khusus Dewan Harian & Pembina).</p>
            </div>
        </div>

        <button onclick="document.getElementById('modalTambahTransaksi').classList.remove('hidden')"
                class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Catat Transaksi
        </button>
    </div>

    {{-- ── Stats Cards ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
        {{-- Total Pemasukan --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Pemasukan</span>
                <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs">Pemasukan</span>
            </div>
            <p class="text-2xl font-extrabold text-emerald-700">Rp {{ number_format($total_masuk, 0, ',', '.') }}</p>
            <p class="text-xs text-slate-400 mt-1">Akumulasi kas masuk</p>
        </div>

        {{-- Total Pengeluaran --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Pengeluaran</span>
                <span class="badge bg-red-50 text-red-700 border border-red-200 text-xs">Pengeluaran</span>
            </div>
            <p class="text-2xl font-extrabold text-red-600">Rp {{ number_format($total_keluar, 0, ',', '.') }}</p>
            <p class="text-xs text-slate-400 mt-1">Akumulasi realisasi biaya</p>
        </div>

        {{-- Saldo Kas --}}
        <div class="bg-white border {{ $saldo >= 0 ? 'border-slate-200' : 'border-red-300 bg-red-50/50' }} rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Saldo Kas Aktif</span>
                <span class="badge {{ $saldo >= 0 ? 'bg-navy/10 text-navy' : 'bg-red-100 text-red-800' }} text-xs">Sisa Kas</span>
            </div>
            <p class="text-2xl font-extrabold {{ $saldo >= 0 ? 'text-slate-900' : 'text-red-700' }}">
                Rp {{ number_format($saldo, 0, ',', '.') }}
            </p>
            <p class="text-xs {{ $saldo >= 0 ? 'text-slate-400' : 'text-red-500' }} mt-1">
                {{ $saldo >= 0 ? 'Status keuangan sehat ✓' : 'Peringatan: Defisit kas!' }}
            </p>
        </div>
    </div>

    {{-- ── Table Transaksi ── --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-base font-semibold text-slate-800">Riwayat Transaksi</h2>
            <span class="text-xs text-slate-400">{{ $records->total() }} catatan</span>
        </div>

        @if($records->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 text-xs font-semibold uppercase tracking-wider text-left">
                            <th class="px-6 py-3.5">Tanggal</th>
                            <th class="px-6 py-3.5">Kegiatan / Keperluan</th>
                            <th class="px-6 py-3.5">Kategori</th>
                            <th class="px-6 py-3.5">Jenis</th>
                            <th class="px-6 py-3.5 text-right">Nominal</th>
                            <th class="px-6 py-3.5">Dicatat Oleh</th>
                            <th class="px-6 py-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($records as $rec)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="px-6 py-4 text-xs text-slate-500 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($rec->created_at)->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-900">
                                    {{ $rec->judul_kegiatan }}
                                    @if($rec->keterangan)
                                        <p class="text-xs font-normal text-slate-500 mt-0.5">{{ $rec->keterangan }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="badge bg-slate-100 text-slate-700 border border-slate-200 text-xs">
                                        {{ $rec->kategori }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($rec->jenis === 'pemasukan')
                                        <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs">
                                            + Pemasukan
                                        </span>
                                    @else
                                        <span class="badge bg-red-50 text-red-700 border border-red-200 text-xs">
                                            - Pengeluaran
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right font-bold {{ $rec->jenis === 'pemasukan' ? 'text-emerald-700' : 'text-red-600' }} whitespace-nowrap">
                                    {{ $rec->jenis === 'pemasukan' ? '+' : '-' }} Rp {{ number_format($rec->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-600 whitespace-nowrap">
                                    {{ $rec->dicatat_oleh ?? '–' }}
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <form method="POST" action="/keuangan/{{ $rec->id }}" onsubmit="return confirm('Hapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-500 hover:text-red-700 p-1 rounded hover:bg-red-50 transition-colors" title="Hapus">
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-slate-100">
                {{ $records->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 14l6-6m0 0l-6-6m6 6H3"/>
                </svg>
                <p class="text-sm text-slate-500 font-medium">Belum ada transaksi kas tercatat</p>
                <p class="text-xs text-slate-400 mt-1">Klik tombol "Catat Transaksi" untuk memasukkan transaksi baru.</p>
            </div>
        @endif
    </div>

</div>

{{-- ── Modal Tambah Transaksi ── --}}
<div id="modalTambahTransaksi" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4" style="background: rgba(15,23,42,0.5);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-base font-bold text-slate-900">Catat Transaksi Keuangan</h3>
            <button onclick="document.getElementById('modalTambahTransaksi').classList.add('hidden')"
                    class="w-8 h-8 rounded-lg border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form method="POST" action="/keuangan" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="form-label" for="judul_kegiatan">Judul Kegiatan / Keperluan <span class="text-red-500">*</span></label>
                <input id="judul_kegiatan" name="judul_kegiatan" type="text" class="form-input"
                       placeholder="Contoh: Pengadaan Konsumsi Sidang Pleno MPR" required>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="form-label" for="jenis">Jenis Transaksi <span class="text-red-500">*</span></label>
                    <select id="jenis" name="jenis" class="form-input" required>
                        <option value="pemasukan">Pemasukan (+)</option>
                        <option value="pengeluaran" selected>Pengeluaran (-)</option>
                    </select>
                </div>
                <div>
                    <label class="form-label" for="kategori">Kategori <span class="text-red-500">*</span></label>
                    <select id="kategori" name="kategori" class="form-input" required>
                        <option value="Konsumsi">Konsumsi</option>
                        <option value="Perlengkapan">Perlengkapan</option>
                        <option value="Transportasi">Transportasi</option>
                        <option value="Iuran Kas">Iuran Kas</option>
                        <option value="Sponsorship">Sponsorship / Donasi</option>
                        <option value="Lain-lain">Lain-lain</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="form-label" for="jumlah">Nominal (Rupiah) <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400 font-semibold">Rp</span>
                    <input id="jumlah" name="jumlah" type="number" min="100" class="form-input" style="padding-left:2.5rem;"
                           placeholder="50000" required>
                </div>
            </div>

            <div>
                <label class="form-label" for="keterangan">Keterangan / Rincian <span class="text-red-500">*</span></label>
                <textarea id="keterangan" name="keterangan" rows="3" class="form-input"
                          placeholder="Tuliskan nomor nota atau rincian pembelian..." required></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button"
                        onclick="document.getElementById('modalTambahTransaksi').classList.add('hidden')"
                        class="px-4 py-2 border border-slate-200 text-slate-600 rounded-lg text-sm hover:bg-slate-50 transition-colors">
                    Batal
                </button>
                <button type="submit" class="btn-primary">
                    Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
