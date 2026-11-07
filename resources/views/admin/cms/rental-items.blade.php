@extends('layouts.admin')

@section('title', 'CMS: Kelola Unit Rental Kamera & Lensa - DEZZLY CREATIVE')

@section('content')
<div class="py-8 sm:py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8"
     x-data="{
         isModalOpen: false,
         isEdit: false,
         modalTitle: 'Tambah Unit Sewa Baru',
         formAction: '{{ route('admin.cms.rental-items.store') }}',
         formMethod: 'POST',
         form: {
             id: null,
             name: '',
             category: 'camera',
             daily_price: 150000,
             sensor_type: 'Full Frame Exmor R BSI CMOS',
             mount_type: 'Sony E-Mount',
             requires_fe_lens: false,
             description: '',
             specs_text: '',
             is_available: true
         },
         openCreate(category = 'camera') {
             this.isEdit = false;
             this.modalTitle = (category === 'camera') ? 'Tambah Unit Kamera Baru' : 'Tambah Unit Lensa Baru';
             this.formAction = '{{ route('admin.cms.rental-items.store') }}';
             this.formMethod = 'POST';
             this.form = {
                 id: null,
                 name: '',
                 category: category,
                 daily_price: (category === 'camera') ? 150000 : 75000,
                 sensor_type: (category === 'camera') ? 'Full Frame Exmor R BSI CMOS' : '',
                 mount_type: 'Sony E-Mount',
                 requires_fe_lens: false,
                 description: '',
                 specs_text: (category === 'camera') ? 'Sensor 24.2 MP Full Frame\nDual SD Card Slot\nBaterai NP-FZ100 Tahan Lama\nVideo 4K HDR 30fps' : 'Bukaan Lensa Cepat f/1.4\nDiameter Filter 67mm\nMotor Fokus Autofokus Cepat\nOptik Tajam Bebas Distorsi',
                 is_available: true
             };
             this.isModalOpen = true;
         },
         openEdit(item) {
             this.isEdit = true;
             this.modalTitle = 'Edit Unit: ' + item.name;
             this.formAction = '/admin/cms/rental-items/' + item.id;
             this.formMethod = 'PUT';
             this.form = {
                 id: item.id,
                 name: item.name,
                 category: item.category,
                 daily_price: item.daily_price,
                 sensor_type: item.sensor_type || '',
                 mount_type: item.mount_type || 'Sony E-Mount',
                 requires_fe_lens: Boolean(item.requires_fe_lens),
                 description: item.description || '',
                 specs_text: Array.isArray(item.specifications) ? item.specifications.join('\n') : '',
                 is_available: Boolean(item.is_available)
             };
             this.isModalOpen = true;
         }
     }">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-6 rounded-2xl bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 shadow-sm">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-purple-500 animate-pulse"></span>
                <span class="text-xs font-extrabold text-slate-500 dark:text-slate-400 uppercase tracking-widest">CMS Rental Kamera</span>
            </div>
            <h1 class="font-extrabold text-2xl sm:text-3xl text-slate-900 dark:text-white mt-1">
                Kelola Katalog Kamera & Lensa Sewa
            </h1>
            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                Tambah jenis kamera baru, ubah harga sewa harian (24 jam), dan sesuaikan spesifikasi teknis unit.
            </p>
        </div>

        <div class="flex items-center gap-2 sm:gap-3">
            <button @click="openCreate('camera')"
                    class="px-4 py-2.5 rounded-xl bg-[#0284C7] hover:bg-[#0369A1] text-white font-extrabold text-xs sm:text-sm shadow-md transition-all hover:scale-105 active:scale-95 cursor-pointer">
                + Tambah Kamera
            </button>
            <button @click="openCreate('lens')"
                    class="px-4 py-2.5 rounded-xl bg-purple-700 hover:bg-purple-800 text-white font-extrabold text-xs sm:text-sm shadow-md transition-all hover:scale-105 active:scale-95 cursor-pointer">
                + Tambah Lensa
            </button>
        </div>
    </div>

    {{-- Feedback Flash Message --}}
    @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border-2 border-emerald-300 dark:border-emerald-700 text-emerald-900 dark:text-emerald-300 text-sm font-bold flex items-center justify-between">
        <span>✓ {{ session('success') }}</span>
    </div>
    @endif

    {{-- Table 1: Kamera --}}
    <div class="bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden shadow-sm">
        <div class="p-6 border-b-2 border-slate-200 dark:border-slate-700 flex items-center justify-between bg-slate-50 dark:bg-slate-800/90">
            <div>
                <h2 class="font-extrabold text-lg text-slate-900 dark:text-white">Daftar Bodi Kamera Sony Alpha</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Unit bodi kamera yang dapat dipilih pengunjung pada kalkulator sewa halaman depan.</p>
            </div>
            <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-sky-100 dark:bg-sky-900/50 text-sky-800 dark:text-sky-300">
                {{ $cameras->count() }} Unit Kamera
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700 dark:text-slate-300">
                <thead class="bg-slate-100 dark:bg-slate-900/60 text-slate-700 dark:text-slate-200 uppercase tracking-wider border-b-2 border-slate-200 dark:border-slate-700 font-extrabold text-xs">
                    <tr>
                        <th class="p-4">Nama Kamera</th>
                        <th class="p-4">Tipe Sensor</th>
                        <th class="p-4">Tarif Sewa (24 Jam)</th>
                        <th class="p-4">Spesifikasi</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700 bg-white dark:bg-slate-800">
                    @forelse($cameras as $camera)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors">
                        <td class="p-4">
                            <strong class="font-extrabold text-base text-slate-900 dark:text-white block">{{ $camera->name }}</strong>
                            <span class="text-xs text-slate-500 dark:text-slate-400 font-mono">{{ $camera->mount_type }}</span>
                        </td>
                        <td class="p-4">
                            <span class="font-semibold text-slate-800 dark:text-slate-200 text-xs">{{ $camera->sensor_type ?? '-' }}</span>
                        </td>
                        <td class="p-4 font-extrabold text-[#0284C7] dark:text-sky-400 text-base">
                            {{ $camera->formatted_price }}
                        </td>
                        <td class="p-4">
                            <span class="text-xs text-slate-600 dark:text-slate-400">{{ count($camera->specifications ?? []) }} poin spek</span>
                        </td>
                        <td class="p-4">
                            <form action="{{ route('admin.cms.rental-items.toggle', $camera) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="px-3 py-1 rounded-full text-xs font-extrabold cursor-pointer transition-all {{ $camera->is_available ? 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-900 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-700' : 'bg-red-100 dark:bg-red-900/40 text-red-900 dark:text-red-300 border border-red-300 dark:border-red-700' }}">
                                    {{ $camera->is_available ? '✓ Tersedia' : '✕ Disewa' }}
                                </button>
                            </form>
                        </td>
                        <td class="p-4 text-right">
                            <div class="inline-flex items-center gap-2">
                                <button type="button"
                                        @click="openEdit({{ json_encode($camera) }})"
                                        class="px-3 py-1.5 rounded-lg bg-sky-50 dark:bg-sky-900/30 border border-sky-300 dark:border-sky-700 text-sky-800 dark:text-sky-300 text-xs font-bold hover:bg-sky-100 dark:hover:bg-sky-900/60 transition-colors cursor-pointer">
                                    Edit
                                </button>
                                <form action="{{ route('admin.cms.rental-items.delete', $camera) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus kamera \'{{ $camera->name }}\'?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1.5 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-300 dark:border-red-700 text-red-700 dark:text-red-300 text-xs font-bold hover:bg-red-100 dark:hover:bg-red-900/60 transition-colors cursor-pointer">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-500 dark:text-slate-400 font-medium">
                            Belum ada kamera yang tersimpan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Table 2: Lensa --}}
    <div class="bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden shadow-sm">
        <div class="p-6 border-b-2 border-slate-200 dark:border-slate-700 flex items-center justify-between bg-slate-50 dark:bg-slate-800/90">
            <div>
                <h2 class="font-extrabold text-lg text-slate-900 dark:text-white">Daftar Pilihan Lensa Kamera</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Lensa tambahan (FE Full Frame & APS-C) yang dapat ditambahkan penyewa ke bodi kamera.</p>
            </div>
            <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-300">
                {{ $lenses->count() }} Pilihan Lensa
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700 dark:text-slate-300">
                <thead class="bg-slate-100 dark:bg-slate-900/60 text-slate-700 dark:text-slate-200 uppercase tracking-wider border-b-2 border-slate-200 dark:border-slate-700 font-extrabold text-xs">
                    <tr>
                        <th class="p-4">Nama Lensa</th>
                        <th class="p-4">Mount & Kompatibilitas</th>
                        <th class="p-4">Tarif Sewa (24 Jam)</th>
                        <th class="p-4">Spesifikasi Optik</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700 bg-white dark:bg-slate-800">
                    @forelse($lenses as $lens)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors">
                        <td class="p-4">
                            <strong class="font-extrabold text-base text-slate-900 dark:text-white block">{{ $lens->name }}</strong>
                            <span class="text-xs text-slate-500 dark:text-slate-400">{{ $lens->mount_type }}</span>
                        </td>
                        <td class="p-4">
                            @if($lens->requires_fe_lens)
                            <span class="text-xs font-bold text-amber-600 dark:text-amber-400">Khusus Bodi Full Frame (FE)</span>
                            @else
                            <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">Kompatibel Semua Bodi</span>
                            @endif
                        </td>
                        <td class="p-4 font-extrabold text-purple-700 dark:text-purple-400 text-base">
                            {{ $lens->formatted_price }}
                        </td>
                        <td class="p-4">
                            <span class="text-xs text-slate-600 dark:text-slate-400">{{ count($lens->specifications ?? []) }} poin optik</span>
                        </td>
                        <td class="p-4">
                            <form action="{{ route('admin.cms.rental-items.toggle', $lens) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="px-3 py-1 rounded-full text-xs font-extrabold cursor-pointer transition-all {{ $lens->is_available ? 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-900 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-700' : 'bg-red-100 dark:bg-red-900/40 text-red-900 dark:text-red-300 border border-red-300 dark:border-red-700' }}">
                                    {{ $lens->is_available ? '✓ Tersedia' : '✕ Disewa' }}
                                </button>
                            </form>
                        </td>
                        <td class="p-4 text-right">
                            <div class="inline-flex items-center gap-2">
                                <button type="button"
                                        @click="openEdit({{ json_encode($lens) }})"
                                        class="px-3 py-1.5 rounded-lg bg-sky-50 dark:bg-sky-900/30 border border-sky-300 dark:border-sky-700 text-sky-800 dark:text-sky-300 text-xs font-bold hover:bg-sky-100 dark:hover:bg-sky-900/60 transition-colors cursor-pointer">
                                    Edit
                                </button>
                                <form action="{{ route('admin.cms.rental-items.delete', $lens) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus lensa \'{{ $lens->name }}\'?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1.5 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-300 dark:border-red-700 text-red-700 dark:text-red-300 text-xs font-bold hover:bg-red-100 dark:hover:bg-red-900/60 transition-colors cursor-pointer">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-500 dark:text-slate-400 font-medium">
                            Belum ada lensa yang tersimpan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL TAMBAH / EDIT UNIT --}}
    <div x-show="isModalOpen"
         x-transition.opacity
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-sm"
         style="display: none;">
        <div @click.away="isModalOpen = false"
             class="bg-white dark:bg-slate-800 p-6 sm:p-8 rounded-2xl max-w-xl w-full border-2 border-slate-300 dark:border-slate-600 shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">

            <div class="flex items-start justify-between border-b-2 border-slate-100 dark:border-slate-700 pb-4">
                <div>
                    <span class="text-xs font-extrabold text-[#0284C7] dark:text-sky-400 uppercase tracking-wider">Formulir CMS Rental</span>
                    <h3 class="font-extrabold text-xl text-slate-900 dark:text-white mt-0.5" x-text="modalTitle"></h3>
                </div>
                <button type="button" @click="isModalOpen = false"
                        class="text-slate-400 hover:text-slate-800 dark:hover:text-white text-2xl font-bold leading-none p-1 cursor-pointer">&times;</button>
            </div>

            <form :action="formAction" method="POST" class="space-y-4 text-sm">
                @csrf
                <template x-if="isEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Kategori Unit:</label>
                    <select name="category" x-model="form.category" required
                            class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white font-bold focus:border-[#0284C7] focus:outline-none">
                        <option value="camera">Kamera (Bodi Sony)</option>
                        <option value="lens">Lensa Kamera</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Nama Unit:</label>
                    <input type="text" name="name" x-model="form.name" required
                           placeholder="Contoh: Sony Alpha A7 IV atau Sigma 24-70mm f/2.8"
                           class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white font-bold focus:border-[#0284C7] focus:outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Tarif Sewa 24 Jam (Rp):</label>
                        <input type="number" name="daily_price" x-model="form.daily_price" min="0" step="5000" required
                               placeholder="150000"
                               class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white font-mono font-bold focus:border-[#0284C7] focus:outline-none">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Mount Lensa:</label>
                        <input type="text" name="mount_type" x-model="form.mount_type" required
                               placeholder="Sony E-Mount"
                               class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:border-[#0284C7] focus:outline-none">
                    </div>
                </div>

                <div x-show="form.category === 'camera'">
                    <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Tipe Sensor:</label>
                    <input type="text" name="sensor_type" x-model="form.sensor_type"
                           placeholder="Contoh: Full Frame 33MP Exmor R BSI CMOS"
                           class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:border-[#0284C7] focus:outline-none">
                </div>

                <div x-show="form.category === 'lens'">
                    <label class="inline-flex items-center gap-2 cursor-pointer font-bold text-sm text-slate-800 dark:text-slate-200">
                        <input type="checkbox" name="requires_fe_lens" x-model="form.requires_fe_lens" value="1"
                               class="w-4 h-4 rounded text-purple-600">
                        <span>Khusus Bodi Full Frame (FE Lens)</span>
                    </label>
                </div>

                <div>
                    <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Spesifikasi Unggulan (1 baris per spesifikasi):</label>
                    <textarea name="specs_text" x-model="form.specs_text" rows="4"
                              placeholder="Resolusi 24.2 MP&#10;Dual Slot Baterai&#10;Fitur Eye-AF Real-time&#10;Bodi Tahan Cuaca"
                              class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl p-3 text-slate-900 dark:text-white focus:border-[#0284C7] focus:outline-none"></textarea>
                </div>

                <div>
                    <label class="inline-flex items-center gap-2 cursor-pointer font-bold text-sm text-slate-800 dark:text-slate-200">
                        <input type="checkbox" name="is_available" x-model="form.is_available" value="1"
                               class="w-4 h-4 rounded text-emerald-600">
                        <span>Unit Tersedia Saat Ini (Bisa Dipesan)</span>
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t-2 border-slate-100 dark:border-slate-700">
                    <button type="button" @click="isModalOpen = false"
                            class="px-5 py-2.5 rounded-xl border-2 border-slate-300 dark:border-slate-600 font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors cursor-pointer">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-6 py-2.5 rounded-xl bg-[#0284C7] hover:bg-[#0369A1] text-white font-extrabold shadow-md transition-all cursor-pointer">
                        Simpan Unit
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection

