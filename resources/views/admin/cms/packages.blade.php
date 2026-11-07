@extends('layouts.admin')

@section('title', 'CMS: Kelola Paket Dokumentasi - DEZZLY CREATIVE')

@section('content')
<div class="py-8 sm:py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8"
     x-data="{
         isModalOpen: false,
         isEdit: false,
         modalTitle: 'Tambah Paket Dokumentasi Baru',
         formAction: '{{ route('admin.cms.packages.store') }}',
         formMethod: 'POST',
         form: {
             id: null,
             name: '',
             subtitle: '',
             base_gear: '',
             crew_fg_count: 1,
             crew_vg_count: 1,
             has_drone: false,
             turnaround_days: 5,
             photo_output: 'All Raw Files + 50 Edited Photos (Google Drive)',
             video_output: '1 Menit Cinematic Teaser + 3-5 Menit Highlight Full HD',
             features_text: '',
             is_popular: false,
             is_active: true
         },
         openCreate() {
             this.isEdit = false;
             this.modalTitle = 'Tambah Paket Dokumentasi Baru';
             this.formAction = '{{ route('admin.cms.packages.store') }}';
             this.formMethod = 'POST';
             this.form = {
                 id: null,
                 name: '',
                 subtitle: '',
                 base_gear: 'Sony A7III / Sony A7C Full Frame',
                 crew_fg_count: 1,
                 crew_vg_count: 1,
                 has_drone: false,
                 turnaround_days: 5,
                 photo_output: 'All Raw Files + 50 Edited Photos (Google Drive)',
                 video_output: '1 Menit Cinematic Teaser + 3-5 Menit Highlight Full HD',
                 features_text: 'Fotografer & Videografer Berpengalaman\nLighting Studio Portable\nEditing Cepat 4-5 Hari Kerja\nKonsultasi Rundown Acara',
                 is_popular: false,
                 is_active: true
             };
             this.isModalOpen = true;
         },
         openEdit(pkg) {
             this.isEdit = true;
             this.modalTitle = 'Edit Paket: ' + pkg.name;
             this.formAction = '/admin/cms/packages/' + pkg.id;
             this.formMethod = 'PUT';
             this.form = {
                 id: pkg.id,
                 name: pkg.name,
                 subtitle: pkg.subtitle || '',
                 base_gear: pkg.base_gear || '',
                 crew_fg_count: pkg.crew_fg_count,
                 crew_vg_count: pkg.crew_vg_count,
                 has_drone: Boolean(pkg.has_drone),
                 turnaround_days: pkg.turnaround_days,
                 photo_output: pkg.photo_output || '',
                 video_output: pkg.video_output || '',
                 features_text: Array.isArray(pkg.features) ? pkg.features.join('\n') : '',
                 is_popular: Boolean(pkg.is_popular),
                 is_active: Boolean(pkg.is_active)
             };
             this.isModalOpen = true;
         }
     }">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-6 rounded-2xl bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 shadow-sm">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-xs font-extrabold text-slate-500 dark:text-slate-400 uppercase tracking-widest">CMS Katalog Layanan</span>
            </div>
            <h1 class="font-extrabold text-2xl sm:text-3xl text-slate-900 dark:text-white mt-1">
                Kelola Paket Jasa Dokumentasi
            </h1>
            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                Atur paket foto, video, rekaman drone, deskripsi, dan fitur layanan yang tampil di landing page.
            </p>
        </div>

        <button @click="openCreate()"
                class="px-5 py-3 rounded-xl bg-[#0284C7] hover:bg-[#0369A1] text-white font-extrabold text-sm shadow-md shadow-sky-600/30 transition-all hover:scale-105 active:scale-95 cursor-pointer flex items-center gap-2">
            <span>+</span>
            <span>Tambah Paket Baru</span>
        </button>
    </div>

    {{-- Feedback Flash Message --}}
    @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border-2 border-emerald-300 dark:border-emerald-700 text-emerald-900 dark:text-emerald-300 text-sm font-bold flex items-center justify-between">
        <span>✓ {{ session('success') }}</span>
    </div>
    @endif

    {{-- Packages Table Card --}}
    <div class="bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden shadow-sm">
        <div class="p-6 border-b-2 border-slate-200 dark:border-slate-700 flex items-center justify-between bg-slate-50 dark:bg-slate-800/90">
            <div>
                <h2 class="font-extrabold text-lg text-slate-900 dark:text-white">Daftar Paket Dokumentasi Aktif & Nonaktif</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Semua paket yang aktif akan otomatis muncul pada bagian "Pilihan Paket Foto & Video" di halaman pengunjung.</p>
            </div>
            <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-slate-200">
                {{ $packages->count() }} Paket
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700 dark:text-slate-300">
                <thead class="bg-slate-100 dark:bg-slate-900/60 text-slate-700 dark:text-slate-200 uppercase tracking-wider border-b-2 border-slate-200 dark:border-slate-700 font-extrabold text-xs">
                    <tr>
                        <th class="p-4">Nama Paket & Subtitle</th>
                        <th class="p-4">Kamera Utama</th>
                        <th class="p-4">Kru & Drone</th>
                        <th class="p-4">Estimasi Selesai</th>
                        <th class="p-4">Tag Populer</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700 bg-white dark:bg-slate-800">
                    @forelse($packages as $pkg)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors">
                        <td class="p-4">
                            <strong class="font-extrabold text-base text-slate-900 dark:text-white block">{{ $pkg->name }}</strong>
                            <span class="text-xs text-slate-500 dark:text-slate-400">{{ $pkg->subtitle ?? '-' }}</span>
                        </td>
                        <td class="p-4">
                            <span class="font-bold text-[#0284C7] dark:text-sky-400 block">{{ $pkg->base_gear }}</span>
                            <span class="text-xs text-slate-500 dark:text-slate-400">{{ count($pkg->features ?? []) }} fitur terdaftar</span>
                        </td>
                        <td class="p-4">
                            <div class="text-xs space-y-0.5">
                                <div>📷 {{ $pkg->crew_fg_count }} Fotografer</div>
                                <div>🎥 {{ $pkg->crew_vg_count }} Videografer</div>
                                @if($pkg->has_drone)
                                <div class="text-emerald-600 dark:text-emerald-400 font-bold">🚁 Drone 4K Termasuk</div>
                                @endif
                            </div>
                        </td>
                        <td class="p-4 font-semibold text-slate-900 dark:text-white">
                            {{ $pkg->turnaround_days }} Hari Kerja
                        </td>
                        <td class="p-4">
                            @if($pkg->is_popular)
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-amber-100 dark:bg-amber-900/40 text-amber-900 dark:text-amber-300 border border-amber-300 dark:border-amber-700 uppercase">
                                ⭐ Populer
                            </span>
                            @else
                            <span class="text-xs text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <form action="{{ route('admin.cms.packages.toggle', $pkg) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="px-3 py-1 rounded-full text-xs font-extrabold cursor-pointer transition-all {{ $pkg->is_active ? 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-900 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-700' : 'bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-400' }}">
                                    {{ $pkg->is_active ? '✓ Aktif' : '✕ Nonaktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="p-4 text-right">
                            <div class="inline-flex items-center gap-2">
                                <button type="button"
                                        @click="openEdit({{ json_encode($pkg) }})"
                                        class="px-3 py-1.5 rounded-lg bg-sky-50 dark:bg-sky-900/30 border border-sky-300 dark:border-sky-700 text-sky-800 dark:text-sky-300 text-xs font-bold hover:bg-sky-100 dark:hover:bg-sky-900/60 transition-colors cursor-pointer">
                                    Edit
                                </button>
                                <form action="{{ route('admin.cms.packages.delete', $pkg) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket \'{{ $pkg->name }}\'?');">
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
                        <td colspan="7" class="p-8 text-center text-slate-500 dark:text-slate-400 font-medium">
                            Belum ada paket dokumentasi yang tersimpan. Klik tombol "Tambah Paket Baru" di atas!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL TAMBAH / EDIT PAKET --}}
    <div x-show="isModalOpen"
         x-transition.opacity
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-sm"
         style="display: none;">
        <div @click.away="isModalOpen = false"
             class="bg-white dark:bg-slate-800 p-6 sm:p-8 rounded-2xl max-w-2xl w-full border-2 border-slate-300 dark:border-slate-600 shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">

            <div class="flex items-start justify-between border-b-2 border-slate-100 dark:border-slate-700 pb-4">
                <div>
                    <span class="text-xs font-extrabold text-[#0284C7] dark:text-sky-400 uppercase tracking-wider">Formulir CMS Paket</span>
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

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Nama Paket:</label>
                        <input type="text" name="name" x-model="form.name" required
                               placeholder="Contoh: Paket Premium Plus Drone"
                               class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white font-bold focus:border-[#0284C7] focus:outline-none">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Subtitle / Peruntukan:</label>
                        <input type="text" name="subtitle" x-model="form.subtitle"
                               placeholder="Contoh: Korporat, Konser & Wedding Akbar"
                               class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:border-[#0284C7] focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Kamera Utama (Base Gear):</label>
                        <input type="text" name="base_gear" x-model="form.base_gear" required
                               placeholder="Contoh: Sony A7III / Sony A7C Full Frame"
                               class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:border-[#0284C7] focus:outline-none">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Estimasi Selesai (Hari):</label>
                        <input type="number" name="turnaround_days" x-model="form.turnaround_days" min="1" required
                               class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:border-[#0284C7] focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-3.5 rounded-xl bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Jumlah Fotografer:</label>
                        <input type="number" name="crew_fg_count" x-model="form.crew_fg_count" min="0" required
                               class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-1.5 text-sm font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Jumlah Videografer:</label>
                        <input type="number" name="crew_vg_count" x-model="form.crew_vg_count" min="0" required
                               class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-1.5 text-sm font-bold">
                    </div>
                    <div class="flex items-center pt-5">
                        <label class="inline-flex items-center gap-2 cursor-pointer font-bold text-xs text-slate-800 dark:text-slate-200">
                            <input type="checkbox" name="has_drone" x-model="form.has_drone" value="1"
                                   class="w-4 h-4 rounded text-[#0284C7]">
                            <span>Sertakan Drone 4K</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Output Hasil Foto:</label>
                    <input type="text" name="photo_output" x-model="form.photo_output" required
                           placeholder="Contoh: All Raw Files + 60 Edited Photos (Google Drive)"
                           class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:border-[#0284C7] focus:outline-none">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Output Hasil Video:</label>
                    <input type="text" name="video_output" x-model="form.video_output" required
                           placeholder="Contoh: 1 Menit Instagram Reels + 3-5 Menit Cinematic 4K"
                           class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:border-[#0284C7] focus:outline-none">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Daftar Fitur Unggulan (1 baris per fitur):</label>
                    <textarea name="features_text" x-model="form.features_text" rows="4"
                              placeholder="Kamera Sony Alpha Full Frame&#10;Pilot Drone Berlisensi&#10;Lighting Wireless Godox&#10;Revisi Warna 2x"
                              class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl p-3 text-slate-900 dark:text-white focus:border-[#0284C7] focus:outline-none"></textarea>
                </div>

                <div class="flex items-center gap-6 pt-2">
                    <label class="inline-flex items-center gap-2 cursor-pointer font-bold text-sm text-slate-800 dark:text-slate-200">
                        <input type="checkbox" name="is_popular" x-model="form.is_popular" value="1"
                               class="w-4 h-4 rounded text-amber-500">
                        <span>Tandai sebagai Paket Populer (Highlight)</span>
                    </label>

                    <label class="inline-flex items-center gap-2 cursor-pointer font-bold text-sm text-slate-800 dark:text-slate-200">
                        <input type="checkbox" name="is_active" x-model="form.is_active" value="1"
                               class="w-4 h-4 rounded text-emerald-600">
                        <span>Aktifkan Paket di Website</span>
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t-2 border-slate-100 dark:border-slate-700">
                    <button type="button" @click="isModalOpen = false"
                            class="px-5 py-2.5 rounded-xl border-2 border-slate-300 dark:border-slate-600 font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors cursor-pointer">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-6 py-2.5 rounded-xl bg-[#0284C7] hover:bg-[#0369A1] text-white font-extrabold shadow-md transition-all cursor-pointer">
                        Simpan Paket
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection

