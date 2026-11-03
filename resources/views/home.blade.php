@extends('layouts.app')

@section('title', 'DEZZLY CREATIVE - Jasa Dokumentasi Event, Drone & Sewa Kamera Sony')

@section('content')
<div x-data="dezzlyApp()">

    {{-- ===================================================================
         HERO SECTION
    =================================================================== --}}
    <section class="relative pt-12 pb-20 bg-gradient-to-b from-sky-50/70 via-white to-slate-50/80 dark:from-slate-900 dark:via-slate-900 dark:to-slate-800 border-b-2 border-slate-200 dark:border-slate-700 overflow-hidden">
        {{-- Interactive Ambient Glow Orbs --}}
        <div class="absolute -top-16 -left-16 w-80 h-80 rounded-full bg-sky-400/20 dark:bg-sky-500/15 blur-3xl pointer-events-none animate-float-slow"></div>
        <div class="absolute top-1/2 -right-20 w-96 h-96 rounded-full bg-emerald-400/15 dark:bg-indigo-500/15 blur-3xl pointer-events-none animate-float-reverse"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto space-y-6">

                {{-- Badge --}}
                <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full border-2 border-sky-300 dark:border-sky-700 bg-sky-100/70 dark:bg-sky-900/30 text-sky-900 dark:text-sky-300 text-xs sm:text-sm font-extrabold tracking-wide uppercase">
                    <span class="w-2.5 h-2.5 rounded-full bg-sky-600 dark:bg-sky-400"></span>
                    Vendor Resmi Dokumentasi Event & Persewaan Kamera
                </div>

                {{-- Headline --}}
                <h1 class="font-extrabold text-3xl sm:text-5xl lg:text-6xl tracking-tight text-slate-900 dark:text-white leading-[1.15]">
                    Abadikan Setiap Momen Berharga.<br>
                    <span class="text-[#0284C7] dark:text-sky-400">Hasil Tajam, Pelayanan Ramah & Terpercaya.</span>
                </h1>

                {{-- Subtext --}}
                <p class="text-base sm:text-xl text-slate-600 dark:text-slate-400 max-w-3xl mx-auto leading-relaxed">
                    Kami melayani kebutuhan dokumentasi foto, rekaman video beresolusi tinggi, pilot drone 4K, hingga persewaan kamera Sony Alpha untuk acara keluarga, pernikahan, gathering kantor, maupun konser resmi.
                </p>

                {{-- CTAs --}}
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                    <a href="#services"
                       class="w-full sm:w-auto px-8 py-4 rounded-xl bg-[#0284C7] hover:bg-[#0369A1] text-white font-extrabold text-base shadow-lg shadow-sky-700/20 transition-all hover:scale-[1.02] active:scale-[0.98]">
                        Lihat Pilihan Paket Foto & Video
                    </a>
                    <a href="#rental"
                       class="w-full sm:w-auto px-8 py-4 rounded-xl border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-extrabold text-base transition-all">
                        Persewaan Kamera Sony (24 Jam)
                    </a>
                </div>

                {{-- Metrics Strip --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-10 text-left">
                    <div class="card-clean p-5 sm:p-6 rounded-2xl">
                        <div class="text-3xl sm:text-4xl font-extrabold text-[#0284C7] dark:text-sky-400">250+</div>
                        <div class="text-sm font-bold text-slate-700 dark:text-slate-300 mt-1">Acara Sukses</div>
                        <div class="text-xs text-slate-500 dark:text-slate-500">Terdokumentasi rapi</div>
                    </div>
                    <div class="card-clean p-5 sm:p-6 rounded-2xl">
                        <div class="text-3xl sm:text-4xl font-extrabold text-emerald-700 dark:text-emerald-400">Drone</div>
                        <div class="text-sm font-bold text-slate-700 dark:text-slate-300 mt-1">Rekaman Udara 4K</div>
                        <div class="text-xs text-slate-500 dark:text-slate-500">Paket lengkap pilihan</div>
                    </div>
                    <div class="card-clean p-5 sm:p-6 rounded-2xl">
                        <div class="text-3xl sm:text-4xl font-extrabold text-purple-700 dark:text-purple-400">4-5 Hari</div>
                        <div class="text-sm font-bold text-slate-700 dark:text-slate-300 mt-1">Hasil Cepat Selesai</div>
                        <div class="text-xs text-slate-500 dark:text-slate-500">Garansi waktu pengerjaan</div>
                    </div>
                    <div class="card-clean p-5 sm:p-6 rounded-2xl">
                        <div class="text-3xl sm:text-4xl font-extrabold text-amber-700 dark:text-amber-400">Sony</div>
                        <div class="text-sm font-bold text-slate-700 dark:text-slate-300 mt-1">Full Frame Alpha</div>
                        <div class="text-xs text-slate-500 dark:text-slate-500">Sensor jernih & tajam</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================================================================
         SECTION 1: PAKET DOKUMENTASI (TANPA HARGA PUBLIK)
    =================================================================== --}}
    <section id="services" class="py-16 sm:py-20 bg-white dark:bg-slate-900 border-b-2 border-slate-200 dark:border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16 space-y-3">
                <span class="text-[#0284C7] dark:text-sky-400 text-sm font-extrabold tracking-widest uppercase">Paket Jasa Dokumentasi</span>
                <h2 class="font-extrabold text-2xl sm:text-3xl lg:text-4xl text-slate-900 dark:text-white">
                    Pilihan Paket Foto, Video & Rekaman Drone
                </h2>
                <p class="text-base text-slate-600 dark:text-slate-400">
                    Harga transparan dan jujur. Konsultasikan kebutuhan Anda untuk mendapatkan penawaran terbaik sesuai acara.
                </p>
                {{-- Harga-on-request notice --}}
                <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-amber-50 dark:bg-amber-900/20 border-2 border-amber-300 dark:border-amber-700 text-amber-900 dark:text-amber-300 text-sm font-bold mt-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Harga diberikan setelah konsultasi — bebas negosiasi sesuai kebutuhan acara
                </div>
            </div>

            {{-- Package Cards Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 sm:gap-6 items-stretch">
                @foreach($packages as $pkg)
                <div class="relative rounded-2xl flex flex-col justify-between p-6 sm:p-7 {{ $pkg->is_popular ? 'card-clean-highlight' : 'card-clean hover:border-slate-400 dark:hover:border-slate-500' }} transition-all duration-300">

                    @if($pkg->is_popular)
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-5 py-1.5 rounded-full shimmer-badge text-white font-extrabold text-xs tracking-wider uppercase shadow-lg shadow-sky-500/25 whitespace-nowrap">
                        ★ Pilihan Paling Favorit
                    </div>
                    @endif

                    <div>
                        {{-- Header --}}
                        <div class="border-b-2 border-slate-100 dark:border-slate-700 pb-5">
                            <h3 class="font-extrabold text-xl sm:text-2xl text-slate-900 dark:text-white">{{ $pkg->name }}</h3>
                            <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mt-1">{{ $pkg->subtitle }}</p>

                            {{-- Harga: TIDAK ditampilkan - hanya label konsultasi --}}
                            <div class="mt-4">
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-extrabold bg-sky-50 dark:bg-sky-900/30 border-2 border-sky-200 dark:border-sky-700 text-sky-800 dark:text-sky-300">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                    </svg>
                                    Hubungi Kami untuk Harga
                                </span>
                            </div>
                        </div>

                        {{-- Key Specs --}}
                        <div class="py-4 space-y-2 text-xs sm:text-sm">
                            <div class="flex items-center justify-between text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-800 px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700">
                                <span class="font-medium">Kamera:</span>
                                <span class="font-bold text-slate-900 dark:text-white text-right max-w-[60%] text-xs leading-tight">{{ $pkg->base_gear }}</span>
                            </div>
                            <div class="flex items-center justify-between text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-800 px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700">
                                <span class="font-medium">Drone 4K:</span>
                                <span class="font-bold {{ $pkg->has_drone ? 'text-emerald-700 dark:text-emerald-400' : 'text-slate-500 dark:text-slate-500' }}">
                                    {{ $pkg->has_drone ? 'Termasuk' : 'Tidak Termasuk' }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-800 px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700">
                                <span class="font-medium">Waktu Selesai:</span>
                                <span class="font-bold text-purple-800 dark:text-purple-400">{{ $pkg->turnaround_days }} Hari Kerja</span>
                            </div>
                        </div>

                        {{-- Features Checklist --}}
                        <div class="pt-2 pb-6">
                            <div class="text-xs font-bold text-slate-500 dark:text-slate-500 uppercase tracking-wider mb-3">Fasilitas yang Didapat:</div>
                            <ul class="space-y-2.5 text-sm text-slate-700 dark:text-slate-300">
                                @if(!empty($pkg->features))
                                    @foreach($pkg->features as $feature)
                                    <li class="flex items-start gap-2.5">
                                        <span class="w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-900/40 text-emerald-800 dark:text-emerald-400 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">&#10003;</span>
                                        <span class="leading-snug">{{ $feature }}</span>
                                    </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                    {{-- CTA Button --}}
                    <button type="button"
                            @click="openInquiryModal({{ $pkg->id }}, '{{ $pkg->name }}', 'Konsultasi')"
                            class="w-full py-4 rounded-xl font-extrabold text-sm uppercase tracking-wider transition-all {{ $pkg->is_popular ? 'bg-[#0284C7] hover:bg-[#0369A1] text-white shadow-md' : 'bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-800 dark:text-slate-200 border-2 border-slate-300 dark:border-slate-600' }}">
                        Tanya Harga & Pesan
                    </button>

                </div>
                @endforeach
            </div>

            {{-- Box Acara Besar --}}
            <div class="mt-12 card-clean p-6 sm:p-8 rounded-2xl flex flex-col md:flex-row items-center justify-between gap-6 bg-sky-50/50 dark:bg-sky-900/10 border-2 border-sky-200 dark:border-sky-800">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-[#0284C7] text-white flex items-center justify-center shrink-0 shadow-md">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m1.636-6.364l.707.707M12 21v-1M6.343 17.657l-.707.707M17.657 17.657l.707.707M12 8v4l3 3"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-slate-900 dark:text-white font-extrabold text-lg">Punya Rencana Acara Besar atau Butuh Siaran Langsung (Live)?</h4>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Kami menyediakan peralatan multicam, siaran langsung ke Zoom/YouTube/Instagram, dan sound system resmi.</p>
                    </div>
                </div>
                <button type="button"
                        @click="openInquiryModal(null, 'Enterprise Multi-Cam & Live Streaming', 'Konsultasi')"
                        class="shrink-0 px-6 py-3.5 rounded-xl bg-white dark:bg-slate-800 border-2 border-[#0284C7] text-[#0284C7] dark:text-sky-400 hover:bg-sky-50 dark:hover:bg-slate-700 font-extrabold text-sm whitespace-nowrap transition-colors shadow-sm">
                    Konsultasi Acara Besar &rarr;
                </button>
            </div>
        </div>
    </section>

    {{-- ===================================================================
         SECTION 2: SEWA KAMERA (TANPA HARGA PUBLIK)
    =================================================================== --}}
    <section id="rental" class="py-16 sm:py-20 bg-[#F8FAFC] dark:bg-slate-800/50 border-b-2 border-slate-200 dark:border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16 space-y-3">
                <span class="text-[#0284C7] dark:text-sky-400 text-sm font-extrabold tracking-widest uppercase">Persewaan Kamera 24 Jam</span>
                <h2 class="font-extrabold text-2xl sm:text-3xl lg:text-4xl text-slate-900 dark:text-white">
                    Sewa Kamera Sony Alpha & Lensa Tambahan
                </h2>
                <p class="text-base text-slate-600 dark:text-slate-400">
                    Pilih tipe kamera yang Anda inginkan, isi formulir, dan tim kami akan menghubungi untuk konfirmasi ketersediaan dan harga sewa.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

                {{-- Left: Camera + Lens Selection --}}
                <div class="lg:col-span-7 space-y-6">

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <h3 class="text-slate-900 dark:text-white font-extrabold text-lg">Langkah 1: Pilih Tipe Kamera</h3>
                        <span class="text-xs font-bold text-slate-500 dark:text-slate-400 bg-slate-200 dark:bg-slate-700 px-3 py-1.5 rounded-full self-start sm:self-auto">Durasi 24 Jam</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <template x-for="cam in cameras" :key="cam.id">
                            <div @click="selectCamera(cam)"
                                 :class="selectedCamera && selectedCamera.id === cam.id
                                     ? 'border-2 border-[#0284C7] bg-sky-50/70 dark:bg-sky-900/20 shadow-md ring-2 ring-sky-200 dark:ring-sky-700'
                                     : 'border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:border-slate-300 dark:hover:border-slate-500'"
                                 class="p-5 rounded-2xl cursor-pointer transition-all flex flex-col justify-between group">
                                <div>
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <h4 class="font-extrabold text-slate-900 dark:text-white text-base" x-text="cam.name"></h4>
                                            <span class="inline-block text-xs font-bold px-2.5 py-1 rounded-md mt-1"
                                                  :class="cam.sensor_type === 'Full Frame'
                                                      ? 'bg-purple-100 dark:bg-purple-900/40 text-purple-900 dark:text-purple-300 border border-purple-300 dark:border-purple-700'
                                                      : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600'"
                                                  x-text="cam.sensor_type"></span>
                                        </div>
                                        {{-- Sensor icon only, no price --}}
                                        <div class="shrink-0 w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-slate-500 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-2.5 leading-relaxed" x-text="cam.description"></p>
                                </div>
                                <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-700 flex items-center justify-between text-xs">
                                    <span class="font-semibold text-slate-600 dark:text-slate-400" x-text="cam.requires_fe_lens ? 'Wajib Lensa Tambahan' : 'Sudah termasuk lensa kit'"></span>
                                    <span class="font-extrabold text-[#0284C7] dark:text-sky-400" x-text="selectedCamera && selectedCamera.id === cam.id ? 'Dipilih' : 'Pilih'"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Full Frame Warning --}}
                    <div x-show="selectedCamera && selectedCamera.requires_fe_lens"
                         x-transition
                         class="p-5 rounded-2xl bg-amber-50 dark:bg-amber-900/20 border-2 border-amber-300 dark:border-amber-700 text-amber-900 dark:text-amber-300 text-sm flex items-start gap-4">
                        <svg class="w-6 h-6 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div>
                            <strong class="font-extrabold block text-base">Catatan: Kamera Full Frame</strong>
                            <p class="mt-1 leading-relaxed">
                                Kamera <strong x-text="selectedCamera ? selectedCamera.name : ''"></strong> (Full Frame) wajib disewa bersama lensa tambahan. Silakan pilih lensa di Langkah 2.
                            </p>
                        </div>
                    </div>

                    {{-- Lens Selection --}}
                    <div class="space-y-3">
                        <h3 class="text-slate-900 dark:text-white font-extrabold text-base sm:text-lg">
                            Langkah 2: Pilih Lensa Tambahan
                            <span class="text-sm font-semibold text-slate-500 dark:text-slate-400">(Opsional / Wajib untuk Full Frame)</span>
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <template x-for="lens in lenses" :key="lens.id">
                                <div @click="selectLens(lens)"
                                     :class="selectedLens && selectedLens.id === lens.id
                                         ? 'border-2 border-[#0284C7] bg-sky-50 dark:bg-sky-900/20 shadow-md ring-2 ring-sky-200 dark:ring-sky-700'
                                         : 'border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:border-slate-300 dark:hover:border-slate-500'"
                                     class="p-4 rounded-xl cursor-pointer transition-all flex flex-col justify-between">
                                    <div>
                                        <div class="text-sm font-extrabold text-slate-900 dark:text-white" x-text="lens.name"></div>
                                        <span class="inline-block text-xs font-semibold text-slate-500 dark:text-slate-400 mt-1" x-text="lens.mount_type"></span>
                                    </div>
                                    <div class="mt-3 pt-2 border-t border-slate-100 dark:border-slate-700 text-xs font-bold text-[#0284C7] dark:text-sky-400 text-right"
                                         x-text="selectedLens && selectedLens.id === lens.id ? 'Dipilih' : '+ Tambahkan'"></div>
                                </div>
                            </template>
                        </div>

                        <div class="text-right" x-show="selectedLens">
                            <button type="button" @click="selectedLens = null"
                                    class="text-xs font-bold text-red-600 dark:text-red-400 hover:underline">
                                Batalkan Pilihan Lensa
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Right: Booking Summary + Form --}}
                <div class="lg:col-span-5">
                    <div class="card-clean p-6 sm:p-7 rounded-2xl lg:sticky lg:top-24 space-y-6">

                        <div class="border-b-2 border-slate-100 dark:border-slate-700 pb-4">
                            <h3 class="font-extrabold text-xl text-slate-900 dark:text-white">Formulir Pemesanan</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Isi data Anda. Konfirmasi ketersediaan & harga via WhatsApp.</p>
                        </div>

                        {{-- Summary --}}
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between items-center text-slate-700 dark:text-slate-300">
                                <span class="font-medium">Kamera Dipilih:</span>
                                <strong class="text-slate-900 dark:text-white font-bold text-right" x-text="selectedCamera ? selectedCamera.name : 'Belum dipilih'"></strong>
                            </div>
                            <div class="flex justify-between items-center text-slate-700 dark:text-slate-300">
                                <span class="font-medium">Lensa Tambahan:</span>
                                <strong class="text-slate-900 dark:text-white font-bold" x-text="selectedLens ? selectedLens.name : 'Tidak ada'"></strong>
                            </div>

                            {{-- Duration --}}
                            <div class="pt-3 border-t-2 border-slate-100 dark:border-slate-700">
                                <label class="block text-slate-900 dark:text-white font-bold mb-2 text-sm">Durasi Sewa:</label>
                                <div class="grid grid-cols-4 gap-2">
                                    <button type="button" @click="rentalDays = 1"
                                            :class="rentalDays === 1 ? 'bg-[#0284C7] text-white font-extrabold shadow-sm' : 'bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-200 border border-slate-300 dark:border-slate-600 font-bold'"
                                            class="py-2.5 rounded-xl text-xs sm:text-sm transition-colors">1 Hari</button>
                                    <button type="button" @click="rentalDays = 2"
                                            :class="rentalDays === 2 ? 'bg-[#0284C7] text-white font-extrabold shadow-sm' : 'bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-200 border border-slate-300 dark:border-slate-600 font-bold'"
                                            class="py-2.5 rounded-xl text-xs sm:text-sm transition-colors">2 Hari</button>
                                    <button type="button" @click="rentalDays = 3"
                                            :class="rentalDays === 3 ? 'bg-[#0284C7] text-white font-extrabold shadow-sm' : 'bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-200 border border-slate-300 dark:border-slate-600 font-bold'"
                                            class="py-2.5 rounded-xl text-xs sm:text-sm transition-colors">3 Hari</button>
                                    <button type="button" @click="rentalDays = 7"
                                            :class="rentalDays === 7 ? 'bg-[#0284C7] text-white font-extrabold shadow-sm' : 'bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-200 border border-slate-300 dark:border-slate-600 font-bold'"
                                            class="py-2.5 rounded-xl text-xs sm:text-sm transition-colors">7 Hari</button>
                                </div>
                            </div>

                            {{-- Harga estimasi: TIDAK ditampilkan - hanya info konsultasi --}}
                            <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 border-2 border-emerald-200 dark:border-emerald-700 text-center mt-2">
                                <p class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider">Harga Sewa</p>
                                <p class="text-sm font-extrabold text-slate-800 dark:text-slate-200 mt-1">
                                    Konfirmasi via WhatsApp setelah pengiriman formulir
                                </p>
                                <p class="text-xs text-slate-500 dark:text-slate-500 mt-1" x-text="'Durasi dipilih: ' + rentalDays + ' hari'"></p>
                            </div>
                        </div>

                        {{-- Form --}}
                        <form @submit.prevent="submitRentalBooking()" class="space-y-3 pt-1">
                            <div>
                                <label class="block text-sm font-bold text-slate-800 dark:text-slate-200 mb-1">Nama Lengkap Anda:</label>
                                <input type="text" x-model="rentalForm.customer_name" required
                                       placeholder="Tuliskan nama Anda"
                                       class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#0284C7] dark:focus:border-sky-500">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-800 dark:text-slate-200 mb-1">Nomor WhatsApp Aktif:</label>
                                <input type="text" x-model="rentalForm.customer_whatsapp" required
                                       placeholder="Contoh: 081234567890"
                                       class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#0284C7] dark:focus:border-sky-500">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-800 dark:text-slate-200 mb-1">Mulai Tanggal Sewa:</label>
                                <input type="date" x-model="rentalForm.start_date" required
                                       class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-[#0284C7] dark:focus:border-sky-500">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-800 dark:text-slate-200 mb-1">Catatan Tambahan (Opsional):</label>
                                <input type="text" x-model="rentalForm.notes"
                                       placeholder="Lokasi pemakaian kamera..."
                                       class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#0284C7] dark:focus:border-sky-500">
                            </div>

                            <button type="submit"
                                    :disabled="isSubmitting || !selectedCamera"
                                    class="w-full py-4 rounded-xl bg-[#15803D] hover:bg-[#166534] text-white font-extrabold text-sm uppercase tracking-wide shadow-md transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                <span x-text="isSubmitting ? 'Sedang Memproses...' : 'Kirim Pemesanan via WhatsApp'"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================================================================
         SECTION: SYARAT & KETENTUAN SEWA KAMERA (SOP KEAMANAN UNIT)
    =================================================================== --}}
    <section id="terms" class="py-16 sm:py-20 bg-white dark:bg-slate-900 border-b-2 border-slate-200 dark:border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16 space-y-3">
                <span class="text-[#0284C7] dark:text-sky-400 text-sm font-extrabold tracking-widest uppercase">Prosedur & SOP Keamanan</span>
                <h2 class="font-extrabold text-2xl sm:text-3xl lg:text-4xl text-slate-900 dark:text-white">
                    Syarat &amp; Ketentuan Sewa Kamera
                </h2>
                <p class="text-base text-slate-600 dark:text-slate-400">
                    Proses sewa mudah, cepat, dan transparan. Harap perhatikan 4 poin utama sebelum melakukan serah terima unit di studio.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- Syarat 1: Identitas --}}
                <div class="card-clean p-6 rounded-2xl space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-sky-100 dark:bg-sky-900/40 text-[#0284C7] dark:text-sky-400 flex items-center justify-center font-extrabold text-xl">
                        1
                    </div>
                    <h3 class="font-extrabold text-lg text-slate-900 dark:text-white">Jaminan Identitas Asli</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        Penyewa wajib menitipkan minimal <strong>2 identitas asli yang masih berlaku</strong> (KTP Asli + SIM / KK / Paspor / STNK kendaraan pribadi).
                    </p>
                </div>

                {{-- Syarat 2: Uji Fisik Bersama --}}
                <div class="card-clean p-6 rounded-2xl space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400 flex items-center justify-center font-extrabold text-xl">
                        2
                    </div>
                    <h3 class="font-extrabold text-lg text-slate-900 dark:text-white">Cek Fisik &amp; Fungsi</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        Sebelum dibawa pulang, penyewa dan petugas studio akan melakukan <strong>inspeksi bersama</strong>: sensor bersih, tombol responsif, LCD jernih, dan baterai terisi.
                    </p>
                </div>

                {{-- Syarat 3: Perhitungan 24 Jam --}}
                <div class="card-clean p-6 rounded-2xl space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-400 flex items-center justify-center font-extrabold text-xl">
                        3
                    </div>
                    <h3 class="font-extrabold text-lg text-slate-900 dark:text-white">Durasi &amp; Toleransi Waktu</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        1 hari sewa dihitung <strong>penuh 24 jam</strong> sejak serah terima unit. Keterlambatan melebihi 1 jam dikenakan biaya per jam agar tidak bentrok dengan penyewa lain.
                    </p>
                </div>

                {{-- Syarat 4: Tanggung Jawab --}}
                <div class="card-clean p-6 rounded-2xl space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400 flex items-center justify-center font-extrabold text-xl">
                        4
                    </div>
                    <h3 class="font-extrabold text-lg text-slate-900 dark:text-white">Tanggung Jawab Pemakaian</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        Seluruh gear dirawat secara berkala. Kerusakan akibat kelalaian (terjatuh, terkena air) menjadi tanggung jawab penyewa sesuai biaya servis resmi Sony.
                    </p>
                </div>

            </div>

            {{-- Tips Tambahan --}}
            <div class="mt-8 p-5 rounded-2xl bg-slate-50 dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <span class="w-3 h-3 rounded-full bg-emerald-500 shrink-0"></span>
                    <p class="text-sm text-slate-700 dark:text-slate-300">
                        <strong>Tips Booking:</strong> Ingin sewa untuk akhir pekan atau libur panjang? Pesan 2–3 hari sebelumnya agar kamera incaran Anda sudah terkunci aman.
                    </p>
                </div>
                <a href="#rental" class="shrink-0 px-5 py-2.5 rounded-xl bg-[#0284C7] hover:bg-[#0369A1] text-white text-xs font-bold whitespace-nowrap transition-colors">
                    Pilih Kamera Sekarang &rarr;
                </a>
            </div>

        </div>
    </section>

    {{-- ===================================================================
         SECTION 3: PORTOFOLIO
    =================================================================== --}}
    <section id="portfolio" class="py-16 sm:py-20 bg-white dark:bg-slate-900 border-b-2 border-slate-200 dark:border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 sm:mb-12 gap-6">
                <div>
                    <span class="text-[#0284C7] dark:text-sky-400 text-sm font-extrabold tracking-widest uppercase">Contoh Karya Kami</span>
                    <h2 class="font-extrabold text-2xl sm:text-3xl lg:text-4xl text-slate-900 dark:text-white mt-1">
                        Portofolio & Pengalaman Acara
                    </h2>
                    <p class="text-base text-slate-600 dark:text-slate-400 mt-2 max-w-xl">
                        Kumpulan hasil dokumentasi acara resmi, perayaan komunitas, dan konser yang telah sukses diselesaikan.
                    </p>
                </div>

                {{-- Category Filters --}}
                <div class="flex flex-wrap gap-2">
                    <button type="button" @click="activeCategory = 'All'"
                            :class="activeCategory === 'All' ? 'bg-[#0284C7] text-white font-extrabold shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-300 border border-slate-300 dark:border-slate-600 font-bold'"
                            class="px-4 py-2 rounded-xl text-sm transition-colors">Semua</button>
                    <button type="button" @click="activeCategory = 'Corporate'"
                            :class="activeCategory === 'Corporate' ? 'bg-[#0284C7] text-white font-extrabold shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-300 border border-slate-300 dark:border-slate-600 font-bold'"
                            class="px-4 py-2 rounded-xl text-sm transition-colors">Perusahaan</button>
                    <button type="button" @click="activeCategory = 'Concert & Show'"
                            :class="activeCategory === 'Concert & Show' ? 'bg-[#0284C7] text-white font-extrabold shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-300 border border-slate-300 dark:border-slate-600 font-bold'"
                            class="px-4 py-2 rounded-xl text-sm transition-colors">Konser</button>
                    <button type="button" @click="activeCategory = 'Brand Activation'"
                            :class="activeCategory === 'Brand Activation' ? 'bg-[#0284C7] text-white font-extrabold shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-300 border border-slate-300 dark:border-slate-600 font-bold'"
                            class="px-4 py-2 rounded-xl text-sm transition-colors">Pameran</button>
                </div>
            </div>

            {{-- Portfolio Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
                @foreach($portfolios as $port)
                <div x-show="activeCategory === 'All' || activeCategory === '{{ $port->category }}'"
                     x-transition
                     class="card-clean rounded-2xl overflow-hidden hover:border-[#0284C7] dark:hover:border-sky-500 transition-all duration-300">

                    <div class="relative h-56 sm:h-72 overflow-hidden bg-slate-100 dark:bg-slate-800">
                        <img src="{{ $port->thumbnail_url }}" alt="{{ $port->title }}"
                             class="w-full h-full object-cover"
                             loading="lazy"
                             onerror="this.src='https://placehold.co/800x450/0284C7/FFFFFF?text=DEZZLY+CREATIVE'">
                        <div class="absolute top-4 left-4">
                            <span class="px-3.5 py-1.5 rounded-lg text-xs font-extrabold bg-white/95 dark:bg-slate-900/90 text-slate-900 dark:text-white border border-slate-200 dark:border-slate-700 uppercase shadow-sm">
                                {{ $port->category }}
                            </span>
                        </div>
                    </div>

                    <div class="p-5 sm:p-6 space-y-4">
                        <div>
                            <span class="text-xs font-extrabold text-[#0284C7] dark:text-sky-400 uppercase">{{ $port->client_name }}</span>
                            <h3 class="font-extrabold text-xl sm:text-2xl text-slate-900 dark:text-white mt-0.5">{{ $port->title }}</h3>
                        </div>

                        <div class="grid grid-cols-2 gap-3 text-xs sm:text-sm bg-slate-50 dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700">
                            <div>
                                <span class="text-slate-500 dark:text-slate-400 block font-medium">Tempat Acara:</span>
                                <strong class="text-slate-900 dark:text-white font-bold">{{ $port->venue }}</strong>
                            </div>
                            <div>
                                <span class="text-slate-500 dark:text-slate-400 block font-medium">Kamera Digunakan:</span>
                                <strong class="text-[#0284C7] dark:text-sky-400 font-bold">{{ $port->gear_used }}</strong>
                            </div>
                        </div>

                        <div class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed">
                            <strong class="text-slate-900 dark:text-white block mb-1">Tujuan & Kebutuhan:</strong>
                            {{ $port->brief }}
                        </div>

                        <div class="p-4 rounded-xl bg-sky-50 dark:bg-sky-900/20 border border-sky-200 dark:border-sky-800 text-sm text-slate-800 dark:text-slate-300">
                            <strong class="text-[#0284C7] dark:text-sky-400 block mb-1">Hasil Eksekusi:</strong>
                            {{ $port->execution_notes }}
                        </div>

                        <div class="flex items-center justify-between text-sm pt-1">
                            <span class="text-slate-600 dark:text-slate-400 font-medium">
                                Peserta: <strong class="text-slate-900 dark:text-white">{{ number_format($port->audience_count) }}+ Orang</strong>
                            </span>
                            <a href="https://wa.me/6282146031398?text=Halo%20Dezzly,%20saya%20tertarik%20dengan%20studi%20kasus%20{{ urlencode($port->title) }}"
                               target="_blank"
                               class="text-[#0284C7] dark:text-sky-400 font-extrabold hover:underline">
                                Tanya Lebih Lanjut &rarr;
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================================================================
         SECTION 4: KEUNGGULAN DEZZLY
    =================================================================== --}}
    <section id="benchmark" class="py-16 sm:py-20 bg-[#F8FAFC] dark:bg-slate-800/50 border-b-2 border-slate-200 dark:border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16 space-y-3">
                <span class="text-emerald-700 dark:text-emerald-400 text-sm font-extrabold tracking-widest uppercase">Perbandingan Kualitas & Layanan</span>
                <h2 class="font-extrabold text-2xl sm:text-3xl lg:text-4xl text-slate-900 dark:text-white">
                    Mengapa Dezzly Pilihan Paling Nyaman?
                </h2>
                <p class="text-base text-slate-600 dark:text-slate-400">
                    Bandingkan fasilitas dan layanan kami dengan vendor dokumentasi pada umumnya.
                </p>
            </div>

            {{-- Comparison Table (responsive) --}}
            <div class="card-clean rounded-2xl overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-700 dark:text-slate-300 min-w-[640px]">
                    <thead class="bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 uppercase tracking-wider border-b-2 border-slate-200 dark:border-slate-700 font-extrabold">
                        <tr>
                            <th class="p-4 sm:p-5">Fasilitas</th>
                            <th class="p-4 sm:p-5 text-[#0284C7] dark:text-sky-400 font-extrabold bg-sky-50 dark:bg-sky-900/20 border-x-2 border-sky-200 dark:border-sky-700">Dezzly Creative</th>
                            <th class="p-4 sm:p-5">Vendor Lepas</th>
                            <th class="p-4 sm:p-5">Agensi Besar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-slate-100 dark:divide-slate-700">
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-slate-900 dark:text-white">Harga Paket Lengkap (Foto + Video + Drone)</td>
                            <td class="p-4 sm:p-5 font-extrabold text-emerald-700 dark:text-emerald-400 bg-sky-50 dark:bg-sky-900/10 border-x-2 border-sky-200 dark:border-sky-700">
                                Terjangkau & Kompetitif
                            </td>
                            <td class="p-4 sm:p-5 text-slate-600 dark:text-slate-400">Lebih Mahal (Drone Terpisah)</td>
                            <td class="p-4 sm:p-5 text-slate-600 dark:text-slate-400">Jauh Lebih Tinggi</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-slate-900 dark:text-white">Tipe Sensor Kamera</td>
                            <td class="p-4 sm:p-5 font-bold text-slate-900 dark:text-white bg-sky-50 dark:bg-sky-900/10 border-x-2 border-sky-200 dark:border-sky-700">
                                Sony Full Frame (Hasil Tajam & Bersih)
                            </td>
                            <td class="p-4 sm:p-5 text-slate-600 dark:text-slate-400">Kamera Standar Pemula</td>
                            <td class="p-4 sm:p-5 text-slate-600 dark:text-slate-400">Full Frame</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-slate-900 dark:text-white">Rekaman Drone 4K</td>
                            <td class="p-4 sm:p-5 font-bold text-emerald-700 dark:text-emerald-400 bg-sky-50 dark:bg-sky-900/10 border-x-2 border-sky-200 dark:border-sky-700">
                                &#10003; Sudah Termasuk di Paket Pilihan
                            </td>
                            <td class="p-4 sm:p-5 text-slate-600 dark:text-slate-400">&#10005; Biaya Tambahan Ekstra</td>
                            <td class="p-4 sm:p-5 text-slate-600 dark:text-slate-400">&#10003; Termasuk (Harga Lebih Tinggi)</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-slate-900 dark:text-white">Kecepatan Selesai Edit</td>
                            <td class="p-4 sm:p-5 font-bold text-purple-900 dark:text-purple-400 bg-sky-50 dark:bg-sky-900/10 border-x-2 border-sky-200 dark:border-sky-700">
                                4 - 5 Hari Kerja (Bergaransi)
                            </td>
                            <td class="p-4 sm:p-5 text-slate-600 dark:text-slate-400">10 - 14 Hari Kerja</td>
                            <td class="p-4 sm:p-5 text-slate-600 dark:text-slate-400">7 - 10 Hari Kerja</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-slate-900 dark:text-white">Revisi & Garansi Kepuasan</td>
                            <td class="p-4 sm:p-5 font-bold text-emerald-700 dark:text-emerald-400 bg-sky-50 dark:bg-sky-900/10 border-x-2 border-sky-200 dark:border-sky-700">
                                &#10003; Revisi Gratis hingga Puas
                            </td>
                            <td class="p-4 sm:p-5 text-slate-600 dark:text-slate-400">Terbatas / Berbayar</td>
                            <td class="p-4 sm:p-5 text-slate-600 dark:text-slate-400">Terbatas</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- CTA after table --}}
            <div class="mt-10 text-center">
                <p class="text-slate-600 dark:text-slate-400 text-base mb-4">Tertarik untuk mengetahui penawaran terbaik kami?</p>
                <button type="button"
                        @click="openInquiryModal(null, 'Konsultasi Umum', 'Konsultasi')"
                        class="px-8 py-4 rounded-xl bg-[#0284C7] hover:bg-[#0369A1] text-white font-extrabold text-base shadow-md transition-all hover:scale-[1.02]">
                    Konsultasi Gratis via WhatsApp &rarr;
                </button>
            </div>
        </div>
    </section>

    {{-- ===================================================================
         SECTION 5: FAQ (PERTANYAAN UMUM & JAWABAN INTERAKTIF)
    =================================================================== --}}
    <section id="faq" class="py-16 sm:py-20 bg-white dark:bg-slate-900 border-b-2 border-slate-200 dark:border-slate-700" x-data="{ activeFaq: null }">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-14 space-y-3">
                <span class="text-[#0284C7] dark:text-sky-400 text-sm font-extrabold tracking-widest uppercase">Pertanyaan Umum</span>
                <h2 class="font-extrabold text-2xl sm:text-3xl lg:text-4xl text-slate-900 dark:text-white">
                    Frequently Asked Questions (FAQ)
                </h2>
                <p class="text-base text-slate-600 dark:text-slate-400">
                    Jawaban cepat untuk hal-hal yang paling sering ditanyakan seputar jasa dokumentasi &amp; persewaan kamera kami.
                </p>
            </div>

            <div class="space-y-4">

                {{-- FAQ 1 --}}
                <div class="card-clean rounded-2xl overflow-hidden">
                    <button type="button"
                            @click="activeFaq = (activeFaq === 1 ? null : 1)"
                            class="w-full p-5 text-left font-extrabold text-base text-slate-900 dark:text-white flex items-center justify-between gap-4">
                        <span>Apakah seluruh file foto dan video mentah (RAW) akan diberikan?</span>
                        <span class="text-xl text-[#0284C7] dark:text-sky-400 font-bold transition-transform" :class="activeFaq === 1 ? 'rotate-45' : ''">+</span>
                    </button>
                    <div x-show="activeFaq === 1" x-transition class="p-5 pt-0 text-sm text-slate-600 dark:text-slate-400 border-t border-slate-100 dark:border-slate-700 leading-relaxed">
                        <strong>Ya, tentu!</strong> Seluruh file foto mentah asli (RAW/JPEG Original) serta rekaman video dari seluruh sudut kamera dan drone akan kami serahkan melalui Google Drive High-Speed tanpa kompresi kualitas.
                    </div>
                </div>

                {{-- FAQ 2 --}}
                <div class="card-clean rounded-2xl overflow-hidden">
                    <button type="button"
                            @click="activeFaq = (activeFaq === 2 ? null : 2)"
                            class="w-full p-5 text-left font-extrabold text-base text-slate-900 dark:text-white flex items-center justify-between gap-4">
                        <span>Berapa lama proses editing foto dan video hingga selesai?</span>
                        <span class="text-xl text-[#0284C7] dark:text-sky-400 font-bold transition-transform" :class="activeFaq === 2 ? 'rotate-45' : ''">+</span>
                    </button>
                    <div x-show="activeFaq === 2" x-transition class="p-5 pt-0 text-sm text-slate-600 dark:text-slate-400 border-t border-slate-100 dark:border-slate-700 leading-relaxed">
                        Kami menjamin estimasi pengerjaan cepat dan tepat waktu: <strong>4 sampai 5 hari kerja</strong> untuk paket menengah dan premium. Untuk kebutuhan mendesak (same-day teaser / reels kilat di hari H), tim kami siap memberikan potongan highlight cepat dalam hitungan jam.
                    </div>
                </div>

                {{-- FAQ 3 --}}
                <div class="card-clean rounded-2xl overflow-hidden">
                    <button type="button"
                            @click="activeFaq = (activeFaq === 3 ? null : 3)"
                            class="w-full p-5 text-left font-extrabold text-base text-slate-900 dark:text-white flex items-center justify-between gap-4">
                        <span>Apakah tim dokumentasi Dezzly melayani acara di luar Jabodetabek?</span>
                        <span class="text-xl text-[#0284C7] dark:text-sky-400 font-bold transition-transform" :class="activeFaq === 3 ? 'rotate-45' : ''">+</span>
                    </button>
                    <div x-show="activeFaq === 3" x-transition class="p-5 pt-0 text-sm text-slate-600 dark:text-slate-400 border-t border-slate-100 dark:border-slate-700 leading-relaxed">
                        <strong>Bisa!</strong> Kami siap melayani acara di seluruh kota di Indonesia (Bandung, Yogyakarta, Surabaya, Bali, dsb). Biaya akomodasi dan transportasi perjalanan darat/udara disesuaikan secara transparan pada penawaran resmi.
                    </div>
                </div>

                {{-- FAQ 4 --}}
                <div class="card-clean rounded-2xl overflow-hidden">
                    <button type="button"
                            @click="activeFaq = (activeFaq === 4 ? null : 4)"
                            class="w-full p-5 text-left font-extrabold text-base text-slate-900 dark:text-white flex items-center justify-between gap-4">
                        <span>Apa saja kelengkapan bawaan saat menyewa kamera di Dezzly?</span>
                        <span class="text-xl text-[#0284C7] dark:text-sky-400 font-bold transition-transform" :class="activeFaq === 4 ? 'rotate-45' : ''">+</span>
                    </button>
                    <div x-show="activeFaq === 4" x-transition class="p-5 pt-0 text-sm text-slate-600 dark:text-slate-400 border-t border-slate-100 dark:border-slate-700 leading-relaxed">
                        Setiap unit sewa kamera sudah dilengkapi dengan: <strong>Bodi kamera Sony, minimal 2 unit baterai original, charger resmi, tali strap kamera empuk, tas pelindung tahan benturan</strong>, dan memory card high-speed (opsional/tersedia).
                    </div>
                </div>

                {{-- FAQ 5 --}}
                <div class="card-clean rounded-2xl overflow-hidden">
                    <button type="button"
                            @click="activeFaq = (activeFaq === 5 ? null : 5)"
                            class="w-full p-5 text-left font-extrabold text-base text-slate-900 dark:text-white flex items-center justify-between gap-4">
                        <span>Bagaimana mekanisme sistem pembayaran, DP, dan pelunasan?</span>
                        <span class="text-xl text-[#0284C7] dark:text-sky-400 font-bold transition-transform" :class="activeFaq === 5 ? 'rotate-45' : ''">+</span>
                    </button>
                    <div x-show="activeFaq === 5" x-transition class="p-5 pt-0 text-sm text-slate-600 dark:text-slate-400 border-t border-slate-100 dark:border-slate-700 leading-relaxed">
                        Untuk jasa dokumentasi, penguncian tanggal dilakukan dengan DP 30%–50%, dan pelunasan dapat dilakukan saat acara selesai atau sebelum penyerahan master file. Untuk sewa kamera, pembayaran sewa dilakukan di awal saat serah terima unit di studio.
                    </div>
                </div>

                {{-- FAQ 6 --}}
                <div class="card-clean rounded-2xl overflow-hidden">
                    <button type="button"
                            @click="activeFaq = (activeFaq === 6 ? null : 6)"
                            class="w-full p-5 text-left font-extrabold text-base text-slate-900 dark:text-white flex items-center justify-between gap-4">
                        <span>Apakah paket dengan rekaman drone sudah termasuk pilot berlisensi?</span>
                        <span class="text-xl text-[#0284C7] dark:text-sky-400 font-bold transition-transform" :class="activeFaq === 6 ? 'rotate-45' : ''">+</span>
                    </button>
                    <div x-show="activeFaq === 6" x-transition class="p-5 pt-0 text-sm text-slate-600 dark:text-slate-400 border-t border-slate-100 dark:border-slate-700 leading-relaxed">
                        <strong>Ya, betul!</strong> Paket dokumentasi kami yang menyertakan drone sudah mencakup unit drone 4K beserta pilot profesional berpengalaman, sehingga Anda tidak perlu memikirkan pengoperasian dan keselamatan penerbangan udara di lokasi.
                    </div>
                </div>

            </div>

            {{-- Still have questions banner --}}
            <div class="mt-10 p-6 rounded-2xl bg-sky-50 dark:bg-sky-900/20 border-2 border-sky-200 dark:border-sky-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
                <div>
                    <h4 class="font-extrabold text-base text-slate-900 dark:text-white">Masih punya pertanyaan khusus yang belum terjawab?</h4>
                    <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">Konsultasikan langsung dengan tim CS kami via WhatsApp. Respon cepat &amp; ramah.</p>
                </div>
                <a href="https://wa.me/6282146031398?text=Halo%20Dezzly%20Creative,%20saya%20ingin%20tanya%20seputar%20layanan"
                   target="_blank"
                   class="shrink-0 px-6 py-3 rounded-xl bg-[#15803D] hover:bg-[#166534] text-white font-extrabold text-xs uppercase tracking-wider transition-all shadow-md">
                    Chat WhatsApp (0821-4603-1398) &rarr;
                </a>
            </div>

        </div>
    </section>

    {{-- ===================================================================
         MODAL: INQUIRY PAKET DOKUMENTASI
    =================================================================== --}}
    <div x-show="isInquiryModalOpen"
         x-transition.opacity
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-sm"
         style="display: none;">
        <div @click.away="isInquiryModalOpen = false"
             class="bg-white dark:bg-slate-800 p-6 sm:p-8 rounded-2xl max-w-lg w-full border-2 border-slate-300 dark:border-slate-600 shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">

            <div class="flex items-start justify-between border-b-2 border-slate-100 dark:border-slate-700 pb-4">
                <div>
                    <span class="text-xs font-extrabold text-[#0284C7] dark:text-sky-400 uppercase tracking-wider">Formulir Pemesanan</span>
                    <h3 class="font-extrabold text-xl sm:text-2xl text-slate-900 dark:text-white" x-text="inquiryTarget.packageName"></h3>
                    <p class="text-sm font-bold text-emerald-700 dark:text-emerald-400 mt-0.5">Harga akan dikonfirmasi oleh tim kami via WhatsApp</p>
                </div>
                <button type="button" @click="isInquiryModalOpen = false"
                        class="text-slate-400 hover:text-slate-800 dark:hover:text-white text-2xl font-bold leading-none p-1">&#10005;</button>
            </div>

            <form @submit.prevent="submitServiceInquiry()" class="space-y-4 text-sm">
                <div>
                    <label class="block text-slate-800 dark:text-slate-200 font-bold mb-1">Nama Lengkap Anda:</label>
                    <input type="text" x-model="inquiryForm.customer_name" required
                           placeholder="Tuliskan nama Anda"
                           class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#0284C7]">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-800 dark:text-slate-200 font-bold mb-1">Nomor WhatsApp:</label>
                        <input type="text" x-model="inquiryForm.customer_whatsapp" required
                               placeholder="0812xxxxxxx"
                               class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#0284C7]">
                    </div>
                    <div>
                        <label class="block text-slate-800 dark:text-slate-200 font-bold mb-1">Instansi / Kantor:</label>
                        <input type="text" x-model="inquiryForm.company_name"
                               placeholder="Opsional"
                               class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#0284C7]">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-800 dark:text-slate-200 font-bold mb-1">Tanggal Acara:</label>
                        <input type="date" x-model="inquiryForm.event_date"
                               class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:outline-none focus:border-[#0284C7]">
                    </div>
                    <div>
                        <label class="block text-slate-800 dark:text-slate-200 font-bold mb-1">Lokasi Acara:</label>
                        <input type="text" x-model="inquiryForm.venue_location"
                               placeholder="Kota / Alamat"
                               class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#0284C7]">
                    </div>
                </div>

                <div>
                    <label class="block text-slate-800 dark:text-slate-200 font-bold mb-1">Rencana Acara & Kebutuhan:</label>
                    <textarea x-model="inquiryForm.brief_notes" rows="3"
                              placeholder="Tuliskan gambaran acara Anda..."
                              class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#0284C7]"></textarea>
                </div>

                <button type="submit"
                        :disabled="isSubmitting"
                        class="w-full py-4 rounded-xl bg-[#0284C7] hover:bg-[#0369A1] text-white font-extrabold text-sm uppercase tracking-wide shadow-md transition-all disabled:opacity-50">
                    <span x-text="isSubmitting ? 'Sedang Mengirim...' : 'Kirim ke WhatsApp Dezzly'"></span>
                </button>
            </form>
        </div>
    </div>

</div>

{{-- ===================================================================
     ALPINE JS DATA COMPONENT
=================================================================== --}}
<script>
function dezzlyApp() {
    return {
        cameras: @json($cameras),
        lenses: @json($lenses),
        selectedCamera: null,
        selectedLens: null,
        rentalDays: 1,
        activeCategory: 'All',
        isSubmitting: false,
        isInquiryModalOpen: false,

        inquiryTarget: {
            packageId: null,
            packageName: '',
            packagePrice: ''
        },

        rentalForm: {
            customer_name: '',
            customer_whatsapp: '',
            start_date: '',
            notes: ''
        },

        inquiryForm: {
            customer_name: '',
            customer_whatsapp: '',
            company_name: '',
            event_date: '',
            venue_location: '',
            brief_notes: ''
        },

        init() {
            if (this.cameras.length > 0) {
                this.selectedCamera = this.cameras[0];
            }
        },

        selectCamera(camera) {
            this.selectedCamera = camera;
        },

        selectLens(lens) {
            if (this.selectedLens && this.selectedLens.id === lens.id) {
                this.selectedLens = null;
            } else {
                this.selectedLens = lens;
            }
        },

        calculateGrandTotal() {
            if (!this.selectedCamera) return 0;
            let daily = this.selectedCamera.daily_price;
            if (this.selectedLens) daily += this.selectedLens.daily_price;
            return daily * this.rentalDays;
        },

        formatRupiah(number) {
            return 'Rp ' + Number(number).toLocaleString('id-ID');
        },

        openInquiryModal(pkgId, name, price) {
            this.inquiryTarget.packageId = pkgId;
            this.inquiryTarget.packageName = name;
            this.inquiryTarget.packagePrice = price;
            this.isInquiryModalOpen = true;
        },

        async submitRentalBooking() {
            if (!this.selectedCamera) {
                alert('Silakan pilih salah satu kamera terlebih dahulu.');
                return;
            }
            if (this.selectedCamera.requires_fe_lens && !this.selectedLens) {
                alert('Perhatian: Kamera Full Frame wajib menyewa lensa tambahan.');
                return;
            }

            this.isSubmitting = true;
            try {
                const response = await fetch('{{ route('rental.order') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        customer_name: this.rentalForm.customer_name,
                        customer_whatsapp: this.rentalForm.customer_whatsapp,
                        start_date: this.rentalForm.start_date,
                        rental_days: this.rentalDays,
                        notes: this.rentalForm.notes,
                        rental_item_id: this.selectedCamera.id,
                        lens_item_id: this.selectedLens ? this.selectedLens.id : null,
                        total_price: this.calculateGrandTotal()
                    })
                });
                const data = await response.json();
                if (data.whatsapp_url) {
                    window.open(data.whatsapp_url, '_blank');
                    this.rentalForm = { customer_name: '', customer_whatsapp: '', start_date: '', notes: '' };
                }
            } catch (e) {
                alert('Terjadi kesalahan. Silakan coba lagi.');
            } finally {
                this.isSubmitting = false;
            }
        },

        async submitServiceInquiry() {
            this.isSubmitting = true;
            try {
                const response = await fetch('{{ route('service.inquiry') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        package_id: this.inquiryTarget.packageId,
                        customer_name: this.inquiryForm.customer_name,
                        customer_whatsapp: this.inquiryForm.customer_whatsapp,
                        company_name: this.inquiryForm.company_name,
                        event_date: this.inquiryForm.event_date,
                        venue_location: this.inquiryForm.venue_location,
                        brief_notes: this.inquiryForm.brief_notes
                    })
                });
                const data = await response.json();
                if (data.whatsapp_url) {
                    window.open(data.whatsapp_url, '_blank');
                    this.isInquiryModalOpen = false;
                    this.inquiryForm = { customer_name: '', customer_whatsapp: '', company_name: '', event_date: '', venue_location: '', brief_notes: '' };
                }
            } catch (e) {
                alert('Terjadi kesalahan. Silakan coba lagi.');
            } finally {
                this.isSubmitting = false;
            }
        }
    }
}
</script>
@endsection
