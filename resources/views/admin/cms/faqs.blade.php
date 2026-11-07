@extends('layouts.admin')

@section('title', 'CMS: Kelola FAQ Pengunjung - DEZZLY CREATIVE')

@section('content')
<div class="py-8 sm:py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8"
     x-data="{
         isModalOpen: false,
         isEdit: false,
         modalTitle: 'Tambah Pertanyaan FAQ Baru',
         formAction: '{{ route('admin.cms.faqs.store') }}',
         formMethod: 'POST',
         form: {
             id: null,
             question: '',
             answer: '',
             category: 'Dokumentasi',
             sort_order: 1,
             is_active: true
         },
         openCreate() {
             this.isEdit = false;
             this.modalTitle = 'Tambah Pertanyaan FAQ Baru';
             this.formAction = '{{ route('admin.cms.faqs.store') }}';
             this.formMethod = 'POST';
             this.form = {
                 id: null,
                 question: '',
                 answer: '',
                 category: 'Dokumentasi',
                 sort_order: 1,
                 is_active: true
             };
             this.isModalOpen = true;
         },
         openEdit(faq) {
             this.isEdit = true;
             this.modalTitle = 'Edit FAQ';
             this.formAction = '/admin/cms/faqs/' + faq.id;
             this.formMethod = 'PUT';
             this.form = {
                 id: faq.id,
                 question: faq.question,
                 answer: faq.answer,
                 category: faq.category || 'Umum',
                 sort_order: faq.sort_order || 1,
                 is_active: Boolean(faq.is_active)
             };
             this.isModalOpen = true;
         }
     }">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-6 rounded-2xl bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 shadow-sm">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-amber-500 animate-pulse"></span>
                <span class="text-xs font-extrabold text-slate-500 dark:text-slate-400 uppercase tracking-widest">CMS Pertanyaan Umum</span>
            </div>
            <h1 class="font-extrabold text-2xl sm:text-3xl text-slate-900 dark:text-white mt-1">
                Kelola FAQ (Pertanyaan yang Sering Diajukan)
            </h1>
            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                Kelola tanya-jawab seputar estimasi pengerjaan, sistem pembayaran DP, cakupan luar kota, dan perlengkapan sewa kamera.
            </p>
        </div>

        <button @click="openCreate()"
                class="px-5 py-3 rounded-xl bg-[#0284C7] hover:bg-[#0369A1] text-white font-extrabold text-sm shadow-md transition-all hover:scale-105 active:scale-95 cursor-pointer flex items-center gap-2">
            <span>+</span>
            <span>Tambah FAQ Baru</span>
        </button>
    </div>

    {{-- Feedback Flash Message --}}
    @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border-2 border-emerald-300 dark:border-emerald-700 text-emerald-900 dark:text-emerald-300 text-sm font-bold flex items-center justify-between">
        <span>✓ {{ session('success') }}</span>
    </div>
    @endif

    {{-- FAQ List Card --}}
    <div class="bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden shadow-sm">
        <div class="p-6 border-b-2 border-slate-200 dark:border-slate-700 flex items-center justify-between bg-slate-50 dark:bg-slate-800/90">
            <div>
                <h2 class="font-extrabold text-lg text-slate-900 dark:text-white">Daftar Pertanyaan & Jawaban Terbit</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Pertanyaan yang berstatus 'Aktif' akan tampil di accordion FAQ halaman pengunjung.</p>
            </div>
            <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-slate-200">
                {{ $faqs->count() }} Pertanyaan
            </span>
        </div>

        <div class="divide-y divide-slate-200 dark:divide-slate-700">
            @forelse($faqs as $faq)
            <div class="p-6 hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors flex flex-col sm:flex-row items-start justify-between gap-4">
                <div class="space-y-2 max-w-3xl">
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded text-[11px] font-bold bg-sky-100 dark:bg-sky-900/50 text-sky-800 dark:text-sky-300">
                            {{ $faq->category }}
                        </span>
                        <span class="text-xs font-mono font-bold text-slate-400">
                            Urutan #{{ $faq->sort_order }}
                        </span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-extrabold uppercase {{ $faq->is_active ? 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-800 dark:text-emerald-300' : 'bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-400' }}">
                            {{ $faq->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                    <h3 class="font-extrabold text-base text-slate-900 dark:text-white">
                        {{ $faq->question }}
                    </h3>
                    <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                        {{ $faq->answer }}
                    </p>
                </div>

                <div class="flex items-center gap-2 shrink-0 pt-2 sm:pt-0">
                    <form action="{{ route('admin.cms.faqs.toggle', $faq) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="px-3 py-1.5 rounded-lg border-2 text-xs font-bold transition-all cursor-pointer {{ $faq->is_active ? 'border-amber-300 dark:border-amber-700 bg-amber-50 dark:bg-amber-900/30 text-amber-900 dark:text-amber-300 hover:bg-amber-100' : 'border-emerald-300 dark:border-emerald-700 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-900 dark:text-emerald-300 hover:bg-emerald-100' }}">
                            {{ $faq->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>

                    <button type="button"
                            @click="openEdit({{ json_encode($faq) }})"
                            class="px-3 py-1.5 rounded-lg bg-sky-50 dark:bg-sky-900/30 border border-sky-300 dark:border-sky-700 text-sky-800 dark:text-sky-300 text-xs font-bold hover:bg-sky-100 dark:hover:bg-sky-900/60 transition-colors cursor-pointer">
                        Edit
                    </button>

                    <form action="{{ route('admin.cms.faqs.delete', $faq) }}" method="POST"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-3 py-1.5 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-300 dark:border-red-700 text-red-700 dark:text-red-300 text-xs font-bold hover:bg-red-100 dark:hover:bg-red-900/60 transition-colors cursor-pointer">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-slate-500 dark:text-slate-400 font-medium">
                Belum ada pertanyaan FAQ yang tersimpan. Klik "Tambah FAQ Baru" di atas!
            </div>
            @endforelse
        </div>
    </div>

    {{-- MODAL TAMBAH / EDIT FAQ --}}
    <div x-show="isModalOpen"
         x-transition.opacity
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-sm"
         style="display: none;">
        <div @click.away="isModalOpen = false"
             class="bg-white dark:bg-slate-800 p-6 sm:p-8 rounded-2xl max-w-xl w-full border-2 border-slate-300 dark:border-slate-600 shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">

            <div class="flex items-start justify-between border-b-2 border-slate-100 dark:border-slate-700 pb-4">
                <div>
                    <span class="text-xs font-extrabold text-[#0284C7] dark:text-sky-400 uppercase tracking-wider">Formulir CMS FAQ</span>
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
                    <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Pertanyaan (Question):</label>
                    <input type="text" name="question" x-model="form.question" required
                           placeholder="Contoh: Berapa lama estimasi penyerahan file foto & video?"
                           class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white font-bold focus:border-[#0284C7] focus:outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Kategori:</label>
                        <select name="category" x-model="form.category" required
                                class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white font-bold focus:border-[#0284C7] focus:outline-none">
                            <option value="Dokumentasi">Dokumentasi</option>
                            <option value="Sewa Kamera">Sewa Kamera</option>
                            <option value="Pembayaran">Pembayaran</option>
                            <option value="Layanan">Layanan & Luar Kota</option>
                            <option value="Umum">Umum</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Urutan Tampil (Sort Order):</label>
                        <input type="number" name="sort_order" x-model="form.sort_order" min="0" required
                               class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:border-[#0284C7] focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-800 dark:text-slate-200 mb-1">Jawaban (Answer):</label>
                    <textarea name="answer" x-model="form.answer" rows="4" required
                              placeholder="Tuliskan jawaban lengkap dan jelas untuk pertanyaan ini..."
                              class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl p-3 text-slate-900 dark:text-white focus:border-[#0284C7] focus:outline-none"></textarea>
                </div>

                <div>
                    <label class="inline-flex items-center gap-2 cursor-pointer font-bold text-sm text-slate-800 dark:text-slate-200">
                        <input type="checkbox" name="is_active" x-model="form.is_active" value="1"
                               class="w-4 h-4 rounded text-emerald-600">
                        <span>Tampilkan di Accordion FAQ Halaman Depan</span>
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t-2 border-slate-100 dark:border-slate-700">
                    <button type="button" @click="isModalOpen = false"
                            class="px-5 py-2.5 rounded-xl border-2 border-slate-300 dark:border-slate-600 font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors cursor-pointer">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-6 py-2.5 rounded-xl bg-[#0284C7] hover:bg-[#0369A1] text-white font-extrabold shadow-md transition-all cursor-pointer">
                        Simpan FAQ
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection

