@extends('layouts.app')
@section('title', 'Tambah Anggota Pengurus')
@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <a href="/monitoring" class="text-blue-600 hover:underline text-sm">&larr; Kembali ke Monitoring</a>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl p-8">
        <h1 class="text-xl font-bold text-slate-900 mb-1">Tambah Anggota Pengurus</h1>
        <p class="text-sm text-slate-500 mb-6">Password default akun baru: <code class="bg-slate-100 px-2 py-0.5 rounded font-mono">wikrama2025</code> — anggota bisa ubah sendiri via menu Ganti Password.</p>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <ul class="text-sm text-red-700 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/monitoring" class="space-y-5">
            @csrf
            
            <!-- Nama Lengkap -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Nama lengkap tanpa gelar">
            </div>

            <!-- Username & Email (2 col) -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Username <span class="text-red-500">*</span></label>
                    <input type="text" name="username" value="{{ old('username') }}" required
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="cth: sekum2025">
                    <p class="text-xs text-slate-400 mt-1">Huruf, angka, _ atau -</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="nama@smkwikrama.sch.id">
                </div>
            </div>

            <!-- Role & Jabatan (2 col) -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Role <span class="text-red-500">*</span></label>
                    <select name="role" required id="roleSelect"
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Role --</option>
                        <option value="pembina" {{ old('role')=='pembina'?'selected':'' }}>Pembina OSIS</option>
                        <option value="dewan_penasihat" {{ old('role')=='dewan_penasihat'?'selected':'' }}>Dewan Penasihat</option>
                        <option value="mpr" {{ old('role')=='mpr'?'selected':'' }}>MPR</option>
                        <option value="dewan_harian" {{ old('role')=='dewan_harian'?'selected':'' }}>Dewan Harian</option>
                        <option value="koordinator_bidang" {{ old('role')=='koordinator_bidang'?'selected':'' }}>Koordinator Bidang</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jabatan <span class="text-red-500">*</span></label>
                    <input type="text" name="jabatan" value="{{ old('jabatan') }}" id="jabatanInput" required
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="cth: Sekretaris Umum">
                </div>
            </div>

            <!-- Bidang (shown only for koordinator) -->
            <div id="bidangWrapper" class="hidden">
                <label class="block text-sm font-medium text-slate-700 mb-1">Seksi Bidang</label>
                <select name="bidang"
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="0">-- Pilih Bidang --</option>
                    <option value="1">Bidang 1 - Keimanan & Ketakwaan</option>
                    <option value="2">Bidang 2 - Budi Pekerti & Akhlak</option>
                    <option value="3">Bidang 3 - Kepribadian & Bela Negara</option>
                    <option value="4">Bidang 4 - Prestasi & Olahraga</option>
                    <option value="5">Bidang 5 - Demokrasi & Lingkungan</option>
                    <option value="6">Bidang 6 - Kreativitas & Kewirausahaan</option>
                    <option value="7">Bidang 7 - Kesehatan & Gizi</option>
                    <option value="8">Bidang 8 - Sastra & Budaya</option>
                    <option value="9">Bidang 9 - TIK</option>
                    <option value="10">Bidang 10 - Bahasa Inggris</option>
                </select>
            </div>

            <!-- Angkatan & Periode (2 col) -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Angkatan</label>
                    <input type="text" name="angkatan" value="{{ old('angkatan', '2025/2026') }}"
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="2025/2026">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Periode Kepengurusan</label>
                    <input type="text" name="periode" value="{{ old('periode', '2025/2026') }}"
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="2025/2026">
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                    class="bg-blue-800 hover:bg-blue-900 text-white font-medium px-6 py-2.5 rounded-lg text-sm transition-colors">
                    Tambah Anggota
                </button>
                <a href="/monitoring" class="text-sm text-slate-500 hover:text-slate-700">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Jabatan suggestions per role
const jabatanMap = {
    pembina:           ['Pembina OSIS'],
    dewan_penasihat:   ['Ketua Dewan Penasihat', 'Anggota Dewan Penasihat'],
    mpr:               ['Ketua MPR', 'Wakil Ketua MPR', 'Sekretaris MPR', 'Anggota MPR'],
    dewan_harian:      ['Ketua Umum','Ketua 1','Ketua 2','Sekretaris Umum','Sekretaris 1','Sekretaris 2','Bendahara Umum','Bendahara 1','Bendahara 2'],
    koordinator_bidang:['Koordinator Bidang 1','Koordinator Bidang 2','Koordinator Bidang 3','Koordinator Bidang 4','Koordinator Bidang 5','Koordinator Bidang 6','Koordinator Bidang 7','Koordinator Bidang 8','Koordinator Bidang 9','Koordinator Bidang 10'],
};

const roleSelect    = document.getElementById('roleSelect');
const jabatanInput  = document.getElementById('jabatanInput');
const bidangWrapper = document.getElementById('bidangWrapper');

function updateRole() {
    const role = roleSelect.value;
    bidangWrapper.classList.toggle('hidden', role !== 'koordinator_bidang');
}

roleSelect.addEventListener('change', function() {
    updateRole();
    const role = this.value;
    // Suggest jabatan
    if (jabatanMap[role] && jabatanMap[role].length === 1) {
        jabatanInput.value = jabatanMap[role][0];
    } else {
        jabatanInput.value = '';
        jabatanInput.placeholder = jabatanMap[role] ? jabatanMap[role].join(' / ') : '';
    }
});

updateRole();
</script>
@endpush
@endsection
