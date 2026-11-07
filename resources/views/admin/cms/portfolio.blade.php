@extends('layouts.admin')

@section('title', 'CMS: Kelola Portofolio Karya - DEZZLY CREATIVE')

@section('content')
<div class="py-8 sm:py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8"
     x-data="{
         isModalOpen: false,
         isEdit: false,
         modalTitle: 'Tambah Portofolio Karya Baru',
         formAction: '{{ route('admin.cms.portfolio.store') }}',
         formMethod: 'POST',
         form: {
             id: null,
             title: '',
             category: 'Corporate Gathering',
             client_name: '',
             venue: '',
             gear_used: 'Sony A7III + Lensa 24-70mm f/2.8 GM + Drone 4K',
             brief: '',
             concept_3d: '',
             sort_order: 0,
             is_featured: false
         },
         openCreate() {
             this.isEdit = false;
             this.modalTitle = 'Tambah Portofolio Karya Baru';
             this.formAction = '{{ route('admin.cms.portfolio.store') }}';
             this.formMethod = 'POST';
             this.form = {
                 id: null,
                 title: '',
                 category: 'Corporate Gathering',
                 client_name: '',
                 venue: 'Jakarta Convention Center (JCC)',
                 gear_used: 'Sony A7III + Lensa 24-70mm f/2.8 GM + Drone 4K',
                 brief: 'Dokumentasi konferensi tahunan dengan highlight teaser 1 menit dan foto liputan 200+ frame beresolusi tinggi.',
                 concept_3d: '',
                 sort_order: 0,
                 is_featured: true
             };
             this.isModalOpen = true;
         },
         openEdit(item) {
             this.isEdit = true;
             this.modalTitle = 'Edit Portofolio: ' + item.title;
             this.formAction = '/admin/cms/portfolio/' + item.id;
             this.formMethod = 'PUT';
             this.form = {
                 id: item.id,
                 title: item.title,
                 category: item.category,
                 client_name: item.client_name,
                 venue: item.venue || '',
                 gear_used: item.gear_used || '',
                 brief: item.brief || '',
                 concept_3d: item.concept_3d || '',
                 sort_order: item.sort_order || 0,
                 is_featured: Boolean(item.is_featured)
             };
             this.isModalOpen = true;
         }
     }">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-6 rounded-2xl bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 shadow-sm">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-indigo-500 animate-pulse"></span>
                <span class="text-xs font-extrabold text-slate-500 dark:text-slate-400 uppercase tracking-widest">CMS Karya & Showcase</span>
            </div>
            <h1 class="font-extrabold text-2xl sm:text-3xl text-slate-900 dark:text-white mt-1">
                Kelola Portofolio & Hasil Karya
            </h1>
            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                Atur karya dokumentasi acara resmi, foto pernikahan, gathering perusahaan, dan video sinematik yang ditampilkan kepada pengunjung.
            </p>
        </div>

        <button @click="openCreate()"
                class="px-5 py-3 rounded-xl bg-[#0284C7] hover:bg-[#0369A1] text-white font-extrabold text-sm shadow-md transition-all hover:scale-105 active:scale-95 cursor-pointer flex items-center gap-2">
            <span>+</span>
            <span>Tambah Karya Baru</span>
        </button>
    </div>

    {{-- Feedback Flash Message --}}
    @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border-2 border-emerald-300 dark:border-emerald-700 text-emerald-900 dark:text-emerald-300 text-sm font-bold flex items-center justify-between">
        <span>✓ {{ session('success') }}</span>
    </div>
    @endif

    {{-- Portfolio Table Card --}}
    <div class="bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden shadow-sm">
        <div class="p-6 border-b-2 border-slate-200 dark:border-slate-700 flex items-center justify-between bg-slate-50 dark:bg-slate-800/90">
            <div>
                <h2 class="font-extrabold text-lg text-slate-900 dark:text-white">Daftar Portofolio Karya Terbit</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Urutkan dan kurasi portofolio terbaik untuk meyakinkan calon klien.</p>
            </div>
            <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-slate-200">
                {{ $portfolios->count() }} Karya
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700 dark:text-slate-300">
                <thead class="bg-slate-100 dark:bg-slate-900/60 text-slate-700 dark:text-slate-200 uppercase tracking-wider border-b-2 border-slate-200 dark:border-slate-700 font-extrabold text-xs">
                    <tr>
                        <th class="p-4">Judul Karya & Kategori</th>
                        <th class="p-4">Nama Klien / Perusahaan</th>
                        <th class="p-4">Lokasi Acara</th>
                        <th class="p-4">Kamera & Lensa</th>
                        <th class="p-4">Urutan</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700 bg-white dark:bg-slate-800">
                    @forelse($portfolios as $item)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors">
                        <td class="p-4">
                            <strong class="font-extrabold text-base text-slate-900 dark:text-white block">{{ $item->title }}</strong>
                            <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[11px] font-bold bg-sky-100 dark:bg-sky-900/40 text-sky-800 dark:text-sky-300">
                                {{ $item->category }}
                            </span>
                        </td>
                        <td class="p-4">
                            <span class="font-bold text-slate-900 dark:text-white">{{ $item->client_name }}</span>
                        </td>
                        <td class="p-4 text-slate-600 dark:text-slate-400 text-xs">
                            {{ $item->venue ?? '-' }}
                        </td>
                        <td class="p-4 text-xs font-medium text-slate-700 dark:text-slate-300">
                            {{ $item->gear_used ?? '-' }}
                        </td>
                        <td class="p-4 font-mono font-bold text-slate-800 dark:text-slate-200">
                            #{{ $item->sort_order }}
                        </td>
                        <td class="p-4 text-right">
                            <div class="inline-flex items-center gap-2">
                                <button type="button"
                                        @click="openEdit({{ json_encode($item) }})"
                                        class="px-3 py-1.5 rounded-lg bg-sky-50 dark:bg-sky-900/30 border border-sky-300 dark:border-sky-700 text-sky-800 dark:text-sky-300 text-xs font-bold hover:bg-sky-100 dark:hover:bg-sky-900/60 transition-colors cursor-pointer">
                                    Edit
                                </button>
                                <form action="{{ route('admin.cms.portfolio.delete', $item) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus portofolio \'{{ $item->title }}\'?');">
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
                            Belum ada karya portofolio yang tersimpan. Klik "Tambah Karya Baru" di atas!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL TAMBAH / EDIT PORTOFOLIO --}}
    <div x-show="isModalOpen"
         x-transition.opacity
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-sm"
         style="display: none;">
        <div @click.away="isModalOpen = false"
             class="bg-white dark:bg-slate-800 p-6 sm:p-8 rounded-2xl max-w-xl w-full border-2 border-slate-300 dark:border-slate-600 shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">

            <div class="flex items-start justify-between border-b-2 border-slate-100 dark:border-slate-700 pb-4">
                <div>
                    <span class="text-xs font-extrabold text-[#0284C7] dark:text-sky-400 uppercase tracking-wider">Formulir CMS Portofolio</span>
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
                    <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Judul Karya / Proyek:</label>
                    <input type="text" name="title" x-model="form.title" required
                           placeholder="Contoh: Astra Honda Motor Corporate Summit 2026"
                           class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white font-bold focus:border-[#0284C7] focus:outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Kategori Acara:</label>
                        <select name="category" x-model="form.category" required
                                class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white font-bold focus:border-[#0284C7] focus:outline-none">
                            <option value="Corporate Gathering">Corporate Gathering</option>
                            <option value="Wedding & Resepsi">Wedding & Resepsi</option>
                            <option value="Konser & Festival">Konser & Festival Musik</option>
                            <option value="Wisuda & Pelantikan">Wisuda & Pelantikan</option>
                            <option value="Komersial & Iklan">Komersial & Iklan</option>
                            <option value="Event Olahraga">Event Olahraga & Outbound</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Nama Klien / Perusahaan:</label>
                        <input type="text" name="client_name" x-model="form.client_name" required
                           placeholder="PT Astra Honda Motor"
                           class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:border-[#0284C7] focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Lokasi / Venue:</label>
                        <input type="text" name="venue" x-model="form.venue"
                               placeholder="Jakarta Convention Center (JCC)"
                               class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:border-[#0284C7] focus:outline-none">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Urutan Tampil (Sort):</label>
                        <input type="number" name="sort_order" x-model="form.sort_order" min="0"
                               class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:border-[#0284C7] focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Peralatan yang Digunakan (Gear):</label>
                    <input type="text" name="gear_used" x-model="form.gear_used"
                           placeholder="Sony A7III + Lensa FE 24-70mm f/2.8 GM + Drone DJI Air 3 4K"
                           class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:border-[#0284C7] focus:outline-none">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Deskripsi Ringkas / Hasil Dokumentasi:</label>
                    <textarea name="brief" x-model="form.brief" rows="3"
                              placeholder="Dokumentasi konferensi tahunan dengan highlight teaser 1 menit dan foto liputan 200+ frame beresolusi tinggi."
                              class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl p-3 text-slate-900 dark:text-white focus:border-[#0284C7] focus:outline-none"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t-2 border-slate-100 dark:border-slate-700">
                    <button type="button" @click="isModalOpen = false"
                            class="px-5 py-2.5 rounded-xl border-2 border-slate-300 dark:border-slate-600 font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors cursor-pointer">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-6 py-2.5 rounded-xl bg-[#0284C7] hover:bg-[#0369A1] text-white font-extrabold shadow-md transition-all cursor-pointer">
                        Simpan Portofolio
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection

