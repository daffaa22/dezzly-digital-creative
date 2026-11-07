@extends('layouts.app')

@section('title', 'DEZZLY CREATIVE - Jasa Dokumentasi Event Sinematik & Drone 4K')

@section('content')
<div x-data="dezzlyApp()">

    {{-- ===================================================================
         HERO SECTION: THE CINEMA ATELIER (LUXURY EDITORIAL AESTHETIC)
    =================================================================== --}}
    <section class="relative pt-14 pb-24 lg:pt-20 lg:pb-32 bg-[#070A12] text-white border-b border-white/10 overflow-hidden cinema-grain">
        {{-- Ambient Luxury Glow Lighting --}}
        <div class="absolute -top-32 left-1/4 w-[500px] h-[500px] rounded-full bg-cyan-500/15 blur-[120px] pointer-events-none animate-float-slow"></div>
        <div class="absolute top-1/3 -right-20 w-[600px] h-[600px] rounded-full bg-indigo-500/10 blur-[140px] pointer-events-none animate-float-reverse"></div>
        <div class="absolute -bottom-24 left-1/3 w-[450px] h-[450px] rounded-full bg-amber-500/10 blur-[130px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto space-y-7">

                {{-- Luxury Studio Badge --}}
                <div class="gsap-reveal inline-flex items-center gap-2.5 px-5 py-2 rounded-full border border-white/15 bg-white/[0.04] backdrop-blur-xl text-slate-200 text-xs sm:text-sm font-semibold tracking-widest uppercase shadow-[0_0_25px_rgba(255,255,255,0.05)]" data-delay="0.1">
                    <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse shadow-[0_0_8px_#38bdf8]"></span>
                    <span>{{ \App\Models\SiteSetting::get('hero_badge', 'STUDIO DOKUMENTASI EVENT & PRODUKSI SINEMATIK') }}</span>
                    <span class="text-slate-600">•</span>
                    <span class="text-cyan-400 font-bold">EST. 2024</span>
                </div>

                {{-- Editorial Headline with Cormorant Garamond Serif Accents --}}
                <h1 class="gsap-reveal font-extrabold text-3xl sm:text-5xl lg:text-6xl xl:text-7xl tracking-tight text-white leading-[1.12]" data-delay="0.2">
                    {{ \App\Models\SiteSetting::get('hero_headline_1', 'Abadikan Setiap Momen Berharga.') }}<br>
                    <span class="font-serif italic font-normal text-gradient-cyan">
                        {{ \App\Models\SiteSetting::get('hero_headline_2', 'Sinematik 4K, Drone Udara & Visual Berkualitas.') }}
                    </span>
                </h1>

                {{-- Refined Subtext --}}
                <p class="gsap-reveal text-base sm:text-xl text-slate-300/90 max-w-3xl mx-auto leading-relaxed font-light" data-delay="0.3">
                    {{ \App\Models\SiteSetting::get('hero_subtext', 'Vendor resmi dokumentasi foto acara, video highlight sinematik, live streaming multicam, dan pilot drone 4K untuk konser, corporate event, wedding, festival musik, dan perayaan penting Anda.') }}
                </p>

                {{-- Dual CTAs --}}
                <div class="gsap-reveal flex flex-col sm:flex-row items-center justify-center gap-4 pt-3" data-delay="0.4">
                    <a href="#services"
                       class="w-full sm:w-auto px-8 py-4 rounded-xl bg-gradient-to-r from-sky-500 via-cyan-500 to-sky-600 hover:from-sky-400 hover:to-cyan-400 text-slate-950 font-extrabold text-base tracking-wide shadow-[0_0_30px_rgba(56,189,248,0.35)] transition-all hover:scale-[1.02] active:scale-[0.98]">
                        Jelajahi Paket Layanan &rarr;
                    </a>
                    <a href="#booking"
                       class="w-full sm:w-auto px-8 py-4 rounded-xl border border-white/20 bg-white/[0.05] hover:bg-white/[0.1] backdrop-blur-xl text-white font-semibold text-base transition-all hover:scale-[1.02] active:scale-[0.98]">
                        Konsultasi / Booking Acara
                    </a>
                </div>

            </div>

            {{-- ===================================================================
                 INTERACTIVE 21:9 ANAMORPHIC CINEMA VIEWFINDER MOCKUP (LIVE HUD)
            =================================================================== --}}
            <div class="mt-14 sm:mt-20 max-w-5xl mx-auto gsap-reveal" data-delay="0.5">
                <div class="relative rounded-3xl p-2 sm:p-3 bg-gradient-to-b from-white/15 via-white/5 to-white/0 border border-white/15 shadow-[0_25px_60px_-15px_rgba(0,0,0,0.9)] backdrop-blur-2xl">

                    <div class="relative aspect-[21/9] sm:aspect-[21/9] rounded-2xl overflow-hidden bg-slate-950 border border-black group select-none">

                        {{-- Cinematic Visual Backdrop --}}
                        <img src="https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=1920&q=80"
                             alt="Dezzly Cinema Production Live Viewfinder"
                             class="w-full h-full object-cover opacity-85 group-hover:scale-105 transition-transform duration-1000 ease-out">

                        {{-- Vignette & Anamorphic Letterbox Glow --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-black/60 pointer-events-none"></div>

                        {{-- Rule-of-Thirds Grid Lines (Subtle) --}}
                        <div class="absolute inset-0 grid grid-cols-3 grid-rows-3 pointer-events-none opacity-20">
                            <div class="border-r border-b border-white/40"></div>
                            <div class="border-r border-b border-white/40"></div>
                            <div class="border-b border-white/40"></div>
                            <div class="border-r border-b border-white/40"></div>
                            <div class="border-r border-b border-white/40"></div>
                            <div class="border-b border-white/40"></div>
                            <div class="border-r border-white/40"></div>
                            <div class="border-r border-white/40"></div>
                            <div></div>
                        </div>

                        {{-- Viewfinder Frame Corners --}}
                        <div class="absolute top-4 left-4 w-6 h-6 border-t-2 border-l-2 border-white/60 pointer-events-none"></div>
                        <div class="absolute top-4 right-4 w-6 h-6 border-t-2 border-r-2 border-white/60 pointer-events-none"></div>
                        <div class="absolute bottom-4 left-4 w-6 h-6 border-b-2 border-l-2 border-white/60 pointer-events-none"></div>
                        <div class="absolute bottom-4 right-4 w-6 h-6 border-b-2 border-r-2 border-white/60 pointer-events-none"></div>

                        {{-- Center Crosshair Focus --}}
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="relative w-8 h-8 flex items-center justify-center">
                                <div class="w-full h-[1px] bg-white/40"></div>
                                <div class="h-full w-[1px] bg-white/40 absolute"></div>
                                <div class="w-3 h-3 rounded-full border border-cyan-400/80 absolute"></div>
                            </div>
                        </div>

                        {{-- LIVE HUD: Top Bar --}}
                        <div class="absolute top-3 sm:top-5 left-4 sm:left-6 right-4 sm:right-6 flex items-center justify-between text-[10px] sm:text-xs font-mono tracking-wider pointer-events-none">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-red-600/90 text-white font-extrabold uppercase shadow-[0_0_12px_#ef4444]">
                                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                                    REC
                                </span>
                                <span class="text-white font-bold hidden sm:inline">4K UHD [3840×2160]</span>
                                <span class="text-cyan-400 font-semibold">24.00 FPS</span>
                            </div>

                            <div class="flex items-center gap-3 text-slate-300">
                                <span class="hidden sm:inline text-slate-400 font-medium">SLOT 1+2: RAW BACKUP</span>
                                <span class="px-2 py-0.5 rounded bg-white/10 text-white font-bold border border-white/15">S-LOG3</span>
                                <span class="text-emerald-400 font-bold">● BATT 98%</span>
                            </div>
                        </div>

                        {{-- LIVE HUD: Bottom Bar --}}
                        <div class="absolute bottom-3 sm:bottom-5 left-4 sm:left-6 right-4 sm:right-6 flex items-end justify-between text-[10px] sm:text-xs font-mono pointer-events-none">
                            <div class="space-y-1">
                                <div class="flex items-center gap-3 text-slate-200">
                                    <span class="font-bold text-white">SHUTTER: 1/48</span>
                                    <span class="text-slate-400">•</span>
                                    <span class="font-bold text-white">IRIS: f/2.8 G-MASTER</span>
                                    <span class="text-slate-400 hidden sm:inline">•</span>
                                    <span class="font-bold text-cyan-400 hidden sm:inline">ISO: 800 BASE DUAL</span>
                                </div>
                                <div class="text-[9px] sm:text-[10px] text-slate-400 tracking-wider">DEZZLY FX-SERIES CINEMATOGRAPHY FEED</div>
                            </div>

                            {{-- Audio Level VU Meter --}}
                            <div class="hidden sm:flex flex-col items-end gap-1 bg-black/60 px-3 py-1.5 rounded-lg border border-white/10 backdrop-blur-md">
                                <div class="flex items-center gap-1.5 text-[9px] text-slate-300">
                                    <span>CH1</span>
                                    <div class="flex gap-0.5">
                                        <span class="w-1.5 h-2.5 bg-emerald-400 rounded-xs"></span>
                                        <span class="w-1.5 h-2.5 bg-emerald-400 rounded-xs"></span>
                                        <span class="w-1.5 h-2.5 bg-emerald-400 rounded-xs"></span>
                                        <span class="w-1.5 h-2.5 bg-emerald-400 rounded-xs"></span>
                                        <span class="w-1.5 h-2.5 bg-emerald-400 rounded-xs"></span>
                                        <span class="w-1.5 h-2.5 bg-yellow-400 rounded-xs"></span>
                                        <span class="w-1.5 h-2.5 bg-slate-700 rounded-xs"></span>
                                    </div>
                                    <span class="text-slate-400">-12dB</span>
                                </div>
                                <div class="flex items-center gap-1.5 text-[9px] text-slate-300">
                                    <span>CH2</span>
                                    <div class="flex gap-0.5">
                                        <span class="w-1.5 h-2.5 bg-emerald-400 rounded-xs"></span>
                                        <span class="w-1.5 h-2.5 bg-emerald-400 rounded-xs"></span>
                                        <span class="w-1.5 h-2.5 bg-emerald-400 rounded-xs"></span>
                                        <span class="w-1.5 h-2.5 bg-emerald-400 rounded-xs"></span>
                                        <span class="w-1.5 h-2.5 bg-yellow-400 rounded-xs"></span>
                                        <span class="w-1.5 h-2.5 bg-slate-700 rounded-xs"></span>
                                        <span class="w-1.5 h-2.5 bg-slate-700 rounded-xs"></span>
                                    </div>
                                    <span class="text-slate-400">-14dB</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ===================================================================
                 BOUTIQUE METRICS STRIP (MINIMALIST LUXURY CARDS)
            =================================================================== --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 pt-12 sm:pt-16 text-left gsap-stagger-container">
                <div class="glass-panel p-5 sm:p-6 rounded-2xl gsap-stagger-item">
                    <div class="text-3xl sm:text-4xl font-extrabold text-cyan-400 animated-counter font-serif italic" data-target="250" data-suffix="+">0</div>
                    <div class="text-sm font-semibold text-white mt-1">{{ \App\Models\SiteSetting::get('metric_1_title', 'Event Terdokumentasi') }}</div>
                    <div class="text-xs text-slate-400 font-light">{{ \App\Models\SiteSetting::get('metric_1_subtitle', 'Konser, gathering, wedding') }}</div>
                </div>
                <div class="glass-panel p-5 sm:p-6 rounded-2xl gsap-stagger-item">
                    <div class="text-3xl sm:text-4xl font-extrabold text-emerald-400 font-serif italic">4K UHD</div>
                    <div class="text-sm font-semibold text-white mt-1">{{ \App\Models\SiteSetting::get('metric_2_title', 'Rekaman Udara Drone') }}</div>
                    <div class="text-xs text-slate-400 font-light">{{ \App\Models\SiteSetting::get('metric_2_subtitle', 'Pilot bersertifikasi resmi') }}</div>
                </div>
                <div class="glass-panel p-5 sm:p-6 rounded-2xl gsap-stagger-item">
                    <div class="text-3xl sm:text-4xl font-extrabold text-purple-400 animated-counter font-serif italic" data-target="48" data-suffix=" Jam">0</div>
                    <div class="text-sm font-semibold text-white mt-1">{{ \App\Models\SiteSetting::get('metric_3_title', 'Teaser Preview Cepat') }}</div>
                    <div class="text-xs text-slate-400 font-light">{{ \App\Models\SiteSetting::get('metric_3_subtitle', 'Highlight siap medsos') }}</div>
                </div>
                <div class="glass-panel p-5 sm:p-6 rounded-2xl gsap-stagger-item">
                    <div class="text-3xl sm:text-4xl font-extrabold text-amber-400 animated-counter font-serif italic" data-target="100" data-suffix="%">0</div>
                    <div class="text-sm font-semibold text-white mt-1">{{ \App\Models\SiteSetting::get('metric_4_title', 'Dual Backup Aman') }}</div>
                    <div class="text-xs text-slate-400 font-light">{{ \App\Models\SiteSetting::get('metric_4_subtitle', 'Garansi anti-hilang data') }}</div>
                </div>
            </div>

        </div>
    </section>

    {{-- ===================================================================
         LUXURY CANNES-STYLE MARQUEE TICKER (KINETIK INFINITE STRIP)
    =================================================================== --}}
    <div class="bg-[#05080E] text-slate-300 py-4 border-y border-white/10 overflow-hidden relative select-none">
        <div class="animate-marquee-infinite flex items-center gap-10 text-xs sm:text-sm font-bold tracking-[0.25em] uppercase">
            <span class="text-cyan-400">✦ DOKUMENTASI EVENT SINEMATIK</span>
            <span class="text-slate-600">•</span>
            <span class="text-emerald-400">✦ PILOT DRONE 4K BERLISENSI APDI</span>
            <span class="text-slate-600">•</span>
            <span class="text-purple-400">✦ SONY FULL FRAME CINEMA LINE</span>
            <span class="text-slate-600">•</span>
            <span class="text-amber-400">✦ MULTICAM LIVE STREAMING BROADCAST</span>
            <span class="text-slate-600">•</span>
            <span class="text-pink-400">✦ COLOR GRADING STANDAR LAYAR LEBAR</span>
            <span class="text-slate-600">•</span>
            <span class="text-cyan-400">✦ AFTERMOVIE TEASER 1 MENIT</span>
            <span class="text-slate-600">•</span>
            {{-- Loop duplicate --}}
            <span class="text-cyan-400">✦ DOKUMENTASI EVENT SINEMATIK</span>
            <span class="text-slate-600">•</span>
            <span class="text-emerald-400">✦ PILOT DRONE 4K BERLISENSI APDI</span>
            <span class="text-slate-600">•</span>
            <span class="text-purple-400">✦ SONY FULL FRAME CINEMA LINE</span>
            <span class="text-slate-600">•</span>
            <span class="text-amber-400">✦ MULTICAM LIVE STREAMING BROADCAST</span>
            <span class="text-slate-600">•</span>
            <span class="text-pink-400">✦ COLOR GRADING STANDAR LAYAR LEBAR</span>
            <span class="text-slate-600">•</span>
            <span class="text-cyan-400">✦ AFTERMOVIE TEASER 1 MENIT</span>
            <span class="text-slate-600">•</span>
        </div>
    </div>

    {{-- ===================================================================
         SECTION 1: HAUTE COUTURE DOCUMENTATION PACKAGES
    =================================================================== --}}
    <section id="services" class="py-20 sm:py-28 bg-[#090D16] text-white border-b border-white/10 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center max-w-3xl mx-auto mb-14 sm:mb-20 space-y-4 gsap-reveal">
                <span class="inline-block text-xs font-bold tracking-[0.25em] uppercase text-cyan-400">Koleksi Layanan Unggulan</span>
                <h2 class="font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white">
                    Pilihan Paket Dokumentasi & Sinematografi
                </h2>
                <p class="text-base text-slate-400 font-light leading-relaxed">
                    Setiap paket dikonfigurasikan dengan kamera full frame bioskop, kru terarah, dan perlindungan backup ganda untuk kesempurnaan momen Anda.
                </p>
                <div class="inline-flex items-center gap-2.5 px-5 py-2 rounded-full bg-white/[0.04] border border-white/10 text-xs sm:text-sm text-slate-300 font-medium">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_8px_#34d399]"></span>
                    Konsultasi Gratis via WhatsApp — Sesuaikan kebutuhan kru dan perlengkapan acara Anda
                </div>
            </div>

            {{-- Package Cards Grid with 3D Tilt --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 sm:gap-7 items-stretch gsap-stagger-container">
                @foreach($packages as $pkg)
                <div class="relative rounded-3xl flex flex-col justify-between p-6 sm:p-8 card-3d-tilt gsap-stagger-item {{ $pkg->is_popular ? 'card-clean-highlight' : 'card-clean' }} transition-all duration-300">

                    @if($pkg->is_popular)
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-5 py-1.5 rounded-full shimmer-badge text-slate-950 font-extrabold text-xs tracking-wider uppercase shadow-xl whitespace-nowrap">
                        ★ Paling Banyak Dipilih
                    </div>
                    @endif

                    <div>
                        {{-- Header --}}
                        <div class="border-b border-slate-200/80 dark:border-white/10 pb-6">
                            <h3 class="font-bold text-xl sm:text-2xl text-slate-900 dark:text-white font-serif italic">{{ $pkg->name }}</h3>
                            <p class="text-xs sm:text-sm font-medium text-slate-600 dark:text-slate-400 mt-1.5 leading-snug">{{ $pkg->subtitle }}</p>

                            <div class="mt-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-cyan-50 dark:bg-cyan-950/50 border border-cyan-500/20 text-cyan-800 dark:text-cyan-300">
                                    💬 Konsultasi & Negosiasi Fleksibel
                                </span>
                            </div>
                        </div>

                        {{-- Spesifikasi Teknis --}}
                        <div class="py-5 border-b border-slate-200/80 dark:border-white/10 space-y-2.5 text-xs">
                            <div class="flex items-center justify-between text-slate-600 dark:text-slate-400">
                                <span class="font-semibold">Kamera Utama:</span>
                                <span class="font-bold text-slate-900 dark:text-slate-200">{{ $pkg->base_gear }}</span>
                            </div>
                            <div class="flex items-center justify-between text-slate-600 dark:text-slate-400">
                                <span class="font-semibold">Kru Lapangan:</span>
                                <span class="font-bold text-slate-900 dark:text-slate-200">{{ $pkg->crew_fg_count }} FG + {{ $pkg->crew_vg_count }} VG</span>
                            </div>
                            <div class="flex items-center justify-between text-slate-600 dark:text-slate-400">
                                <span class="font-semibold">Drone 4K:</span>
                                <span class="font-bold {{ $pkg->has_drone ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400' }}">
                                    {{ $pkg->has_drone ? '✓ Termasuk Pilot Drone' : '✕ Tidak Termasuk' }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-slate-600 dark:text-slate-400">
                                <span class="font-semibold">Waktu Editing:</span>
                                <span class="font-bold text-slate-900 dark:text-slate-200">{{ $pkg->turnaround_days }} Hari Kerja</span>
                            </div>
                        </div>

                        {{-- Fitur / Output --}}
                        <div class="pt-5 space-y-2.5 text-xs text-slate-600 dark:text-slate-300 font-light">
                            @if(is_array($pkg->features))
                                @foreach($pkg->features as $feat)
                                <div class="flex items-start gap-2.5">
                                    <span class="text-cyan-600 dark:text-cyan-400 font-bold shrink-0">✦</span>
                                    <span>{{ $feat }}</span>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    {{-- CTA Button --}}
                    <div class="pt-6 mt-6 border-t border-slate-200/80 dark:border-white/10 space-y-2">
                        <button type="button"
                                @click="openInquiryModal({{ $pkg->id }}, '{{ addslashes($pkg->name) }}')"
                                class="w-full py-3.5 px-4 rounded-xl text-center font-bold text-xs uppercase tracking-widest transition-all {{ $pkg->is_popular ? 'bg-gradient-to-r from-sky-500 to-cyan-500 hover:from-sky-400 hover:to-cyan-400 text-slate-950 shadow-md shadow-cyan-500/20' : 'bg-slate-100 dark:bg-white/[0.05] hover:bg-slate-200 dark:hover:bg-white/[0.1] text-slate-900 dark:text-white border border-slate-200 dark:border-white/10' }} cursor-pointer">
                            Konsultasikan Paket Ini &rarr;
                        </button>

                        <button type="button"
                                @click="if(window.openNegotiationChat) window.openNegotiationChat({{ $pkg->id }}, '{{ addslashes($pkg->name) }}')"
                                class="w-full py-2 px-3 text-center text-xs font-semibold text-cyan-400 hover:text-cyan-300 transition-colors flex items-center justify-center gap-1.5 cursor-pointer">
                            <span>💬</span>
                            <span>Nego Harga Langsung via Chat</span>
                        </button>
                    </div>

                </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ===================================================================
         SECTION 2: CAMERA & LENS RENTAL DESK
    =================================================================== --}}
    <section id="rental" class="py-20 sm:py-28 bg-[#070A12] text-white border-b border-white/10 relative overflow-hidden">
        <div class="absolute top-0 right-1/4 w-[420px] h-[420px] rounded-full bg-cyan-500/10 blur-[130px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-14 sm:mb-20 space-y-4 gsap-reveal">
                <span class="inline-block text-xs font-bold tracking-[0.25em] uppercase text-cyan-400">Rental Gear Studio</span>
                <h2 class="font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white">
                    Sewa Kamera & Lensa Sony Alpha
                </h2>
                <p class="text-base text-slate-400 font-light leading-relaxed">
                    Sewa unit kamera dan lensa pilihan studio untuk kebutuhan produksi mandiri Anda. Semua unit dirawat berkala, lengkap dengan baterai cadangan, memory card, dan tas.
                </p>
                <div class="inline-flex items-center gap-2.5 px-5 py-2 rounded-full bg-white/[0.04] border border-white/10 text-xs sm:text-sm text-slate-300 font-medium">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_8px_#34d399]"></span>
                    Konfirmasi ketersediaan unit langsung via WhatsApp
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 items-start">

                {{-- Camera Catalog --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 gsap-stagger-container">
                        @foreach($cameras as $camera)
                        <button type="button"
                                @click="selectRentalCamera({{ $camera->id }})"
                                class="text-left rounded-2xl border-2 p-4 sm:p-5 transition-all duration-200 cursor-pointer gsap-stagger-item"
                                :class="rentalForm.rental_item_id === {{ $camera->id }} ? 'border-cyan-400 bg-cyan-500/10 shadow-[0_0_25px_rgba(34,211,238,0.15)]' : 'border-white/10 bg-white/[0.03] hover:border-white/25'">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h3 class="font-bold text-lg text-white leading-tight">{{ $camera->name }}</h3>
                                    <p class="text-[11px] uppercase tracking-widest text-cyan-400 font-bold mt-1">{{ $camera->sensor_type ?? 'Sony Alpha' }} • {{ $camera->mount_type ?? 'E-Mount' }}</p>
                                </div>
                                <span class="text-xs font-extrabold px-2.5 py-1 rounded-lg bg-slate-950/60 border border-white/10 text-emerald-400 whitespace-nowrap">{{ $camera->formatted_price }}/hari</span>
                            </div>

                            @if($camera->description)
                            <p class="text-xs text-slate-400 font-light leading-relaxed mt-3 line-clamp-2">{{ $camera->description }}</p>
                            @endif

                            <div class="flex items-center gap-2 mt-3">
                                @if($camera->requires_fe_lens)
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-500/15 border border-amber-400/30 text-amber-300">Butuh lensa FE</span>
                                @else
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-500/15 border border-emerald-400/30 text-emerald-300">Siap pakai</span>
                                @endif
                                <span x-show="rentalForm.rental_item_id === {{ $camera->id }}" class="text-[10px] font-bold text-cyan-300">✓ Dipilih</span>
                            </div>
                        </button>
                        @endforeach
                    </div>

                    <div class="glass-panel rounded-2xl p-5 sm:p-6">
                        <label class="block text-slate-300 font-semibold text-sm mb-2">Pilih Lensa Tambahan (Opsional):</label>
                        <select x-model="rentalForm.lens_item_id"
                                class="w-full bg-[#0B0F19] border border-white/15 rounded-xl px-4 py-3.5 text-sm text-white focus:outline-none focus:border-cyan-400 transition-colors">
                            <option value="" class="bg-[#0B0F19]">-- Tanpa lensa tambahan --</option>
                            @foreach($lenses as $lens)
                            <option value="{{ $lens->id }}" class="bg-[#0B0F19]">{{ $lens->name }} — {{ $lens->formatted_price }}/hari</option>
                            @endforeach
                        </select>
                        <p class="text-[11px] text-slate-500 mt-2">Kamera Full Frame (A7-Series) wajib menggunakan lensa FE. Lensa APS-C tetap kompatibel untuk bodi APS-C.</p>
                    </div>
                </div>

                {{-- Booking Summary & Form --}}
                <div class="glass-panel rounded-3xl p-6 sm:p-8 shadow-2xl lg:sticky lg:top-24">
                    <h3 class="font-bold text-xl text-white font-serif italic">Ringkasan Sewa</h3>
                    <p class="text-xs text-slate-400 mt-1">Estimasi biaya dihitung otomatis.</p>

                    <div class="mt-5 space-y-3 text-sm">
                        <div class="flex items-start justify-between gap-3">
                            <span class="text-slate-400">Kamera</span>
                            <span class="font-bold text-white text-right" x-text="selectedCamera ? selectedCamera.name : 'Belum dipilih'"></span>
                        </div>
                        <div class="flex items-start justify-between gap-3">
                            <span class="text-slate-400">Lensa</span>
                            <span class="font-bold text-white text-right" x-text="selectedLens ? selectedLens.name : 'Tanpa lensa'"></span>
                        </div>
                        <div class="flex items-center justify-between gap-3">
                            <span class="text-slate-400">Harga / hari</span>
                            <span class="font-bold text-cyan-400" x-text="formatRupiah(rentalDailyTotal)"></span>
                        </div>
                        <div class="flex items-center justify-between gap-3 pt-3 border-t border-white/10">
                            <span class="text-slate-300 font-semibold">Estimasi Total</span>
                            <span class="font-extrabold text-xl text-emerald-400" x-text="formatRupiah(rentalGrandTotal)"></span>
                        </div>
                    </div>

                    <form @submit.prevent="submitRentalOrder()" class="mt-6 space-y-4">
                        <div>
                            <label class="block text-slate-300 font-semibold text-xs mb-1.5">Tanggal Mulai Sewa:</label>
                            <input type="date" x-model="rentalForm.start_date" required
                                   class="w-full bg-white/[0.04] border border-white/15 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-cyan-400 transition-colors">
                        </div>
                        <div>
                            <label class="block text-slate-300 font-semibold text-xs mb-1.5">Durasi (hari):</label>
                            <input type="number" min="1" max="30" x-model.number="rentalForm.duration_days" required
                                   class="w-full bg-white/[0.04] border border-white/15 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-cyan-400 transition-colors">
                        </div>
                        <div>
                            <label class="block text-slate-300 font-semibold text-xs mb-1.5">Nama Lengkap:</label>
                            <input type="text" x-model="rentalForm.customer_name" required
                                   placeholder="Nama penyewa"
                                   class="w-full bg-white/[0.04] border border-white/15 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400 transition-colors">
                        </div>
                        <div>
                            <label class="block text-slate-300 font-semibold text-xs mb-1.5">Nomor WhatsApp:</label>
                            <input type="text" x-model="rentalForm.customer_whatsapp" required
                                   placeholder="0812xxxxxxx"
                                   class="w-full bg-white/[0.04] border border-white/15 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400 transition-colors">
                        </div>
                        <div>
                            <label class="block text-slate-300 font-semibold text-xs mb-1.5">Catatan (Opsional):</label>
                            <textarea x-model="rentalForm.notes" rows="2"
                                      placeholder="Kebutuhan khusus atau lokasi pengambilan unit"
                                      class="w-full bg-white/[0.04] border border-white/15 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400 transition-colors"></textarea>
                        </div>

                        <button type="submit"
                                :disabled="isSubmittingRental"
                                class="w-full py-4 rounded-xl bg-gradient-to-r from-emerald-500 to-cyan-500 hover:from-emerald-400 hover:to-cyan-400 text-slate-950 font-extrabold text-sm uppercase tracking-widest shadow-[0_0_25px_rgba(16,185,129,0.3)] transition-all hover:scale-[1.01] active:scale-[0.98] disabled:opacity-50 cursor-pointer">
                            <span x-text="isSubmittingRental ? 'Memproses Booking...' : 'Booking via WhatsApp →'"></span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>

    {{-- ===================================================================
         SECTION 2B: THE STUDIO PRODUCTION METHOD (EDITORIAL TIMELINE)
    =================================================================== --}}
    <section id="workflow" class="py-20 sm:py-28 bg-[#070A12] text-white border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center max-w-3xl mx-auto mb-16 sm:mb-20 space-y-4 gsap-reveal">
                <span class="inline-block text-xs font-bold tracking-[0.25em] uppercase text-cyan-400">Standar Produksi</span>
                <h2 class="font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white">
                    Alur Produksi Dezzly Cinema Atelier
                </h2>
                <p class="text-base text-slate-400 font-light leading-relaxed">
                    Bagaimana kami memastikan setiap detik acara Anda diabadikan secara sempurna dari perencanaan hingga serah terima file beresolusi tinggi.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 sm:gap-8 gsap-stagger-container">
                {{-- Step 1 --}}
                <div class="glass-panel card-3d-tilt p-7 rounded-3xl space-y-4 gsap-stagger-item relative">
                    <div class="w-12 h-12 rounded-2xl bg-cyan-950/70 border border-cyan-400/40 text-cyan-300 font-serif italic text-2xl flex items-center justify-center">
                        01
                    </div>
                    <h3 class="font-bold text-xl text-white">Brief & Rundown</h3>
                    <p class="text-xs sm:text-sm text-slate-400 font-light leading-relaxed">
                        Diskusi mendalam mengenai rundown acara, sudut pandang krusial, dress code, dan tone visual (mood video) yang diinginkan klien.
                    </p>
                </div>

                {{-- Step 2 --}}
                <div class="glass-panel card-3d-tilt p-7 rounded-3xl space-y-4 gsap-stagger-item relative">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-950/70 border border-emerald-400/40 text-emerald-300 font-serif italic text-2xl flex items-center justify-center">
                        02
                    </div>
                    <h3 class="font-bold text-xl text-white">Shooting di Lokasi</h3>
                    <p class="text-xs sm:text-sm text-slate-400 font-light leading-relaxed">
                        Kru hadir 1 jam sebelum acara dimulai. Pengambilan gambar darat & udara 4K dengan audio mikrofon eksternal berkualitas prima.
                    </p>
                </div>

                {{-- Step 3 --}}
                <div class="glass-panel card-3d-tilt p-7 rounded-3xl space-y-4 gsap-stagger-item relative">
                    <div class="w-12 h-12 rounded-2xl bg-purple-950/70 border border-purple-400/40 text-purple-300 font-serif italic text-2xl flex items-center justify-center">
                        03
                    </div>
                    <h3 class="font-bold text-xl text-white">Editing & Color Grade</h3>
                    <p class="text-xs sm:text-sm text-slate-400 font-light leading-relaxed">
                        Kurasi foto terbaik, pewarnaan color grading sinematik standar layar lebar, sound design, serta penataan musik berlisensi resmi.
                    </p>
                </div>

                {{-- Step 4 --}}
                <div class="glass-panel card-3d-tilt p-7 rounded-3xl space-y-4 gsap-stagger-item relative">
                    <div class="w-12 h-12 rounded-2xl bg-amber-950/70 border border-amber-400/40 text-amber-300 font-serif italic text-2xl flex items-center justify-center">
                        04
                    </div>
                    <h3 class="font-bold text-xl text-white">Serah Terima Cloud</h3>
                    <p class="text-xs sm:text-sm text-slate-400 font-light leading-relaxed">
                        Akses cloud drive berkecepatan tinggi dengan masa simpan aktif, plus penyerahan teaser 1 menit untuk konsumsi media sosial Anda.
                    </p>
                </div>
            </div>

        </div>
    </section>

    {{-- ===================================================================
         SECTION 3: WIDESCREEN CINEMA PORTFOLIO SHOWCASE
    =================================================================== --}}
    <section id="portfolio" class="py-20 sm:py-28 bg-[#090D16] text-white border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 gap-6 gsap-reveal">
                <div>
                    <span class="inline-block text-xs font-bold tracking-[0.25em] uppercase text-cyan-400">Hasil Karya Terpilih</span>
                    <h2 class="font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white mt-1">
                        Portofolio Dokumentasi Acara
                    </h2>
                    <p class="text-base text-slate-400 font-light mt-2 max-w-xl">
                        Kumpulan cuplikan dokumentasi acara resmi perusahaan, festival musik panggung, dan momen penting yang sukses dikerjakan.
                    </p>
                </div>

                {{-- Category Filters --}}
                <div class="flex flex-wrap gap-2.5">
                    <button type="button" @click="activeCategory = 'All'"
                            :class="activeCategory === 'All' ? 'bg-cyan-500 text-slate-950 font-bold shadow-[0_0_15px_rgba(56,189,248,0.3)]' : 'bg-white/[0.05] hover:bg-white/[0.1] text-slate-300 border border-white/10 font-medium'"
                            class="px-4 py-2 rounded-xl text-xs sm:text-sm transition-all cursor-pointer">Semua</button>
                    <button type="button" @click="activeCategory = 'Corporate'"
                            :class="activeCategory === 'Corporate' ? 'bg-cyan-500 text-slate-950 font-bold shadow-[0_0_15px_rgba(56,189,248,0.3)]' : 'bg-white/[0.05] hover:bg-white/[0.1] text-slate-300 border border-white/10 font-medium'"
                            class="px-4 py-2 rounded-xl text-xs sm:text-sm transition-all cursor-pointer">Perusahaan</button>
                    <button type="button" @click="activeCategory = 'Concert & Show'"
                            :class="activeCategory === 'Concert & Show' ? 'bg-cyan-500 text-slate-950 font-bold shadow-[0_0_15px_rgba(56,189,248,0.3)]' : 'bg-white/[0.05] hover:bg-white/[0.1] text-slate-300 border border-white/10 font-medium'"
                            class="px-4 py-2 rounded-xl text-xs sm:text-sm transition-all cursor-pointer">Konser</button>
                    <button type="button" @click="activeCategory = 'Brand Activation'"
                            :class="activeCategory === 'Brand Activation' ? 'bg-cyan-500 text-slate-950 font-bold shadow-[0_0_15px_rgba(56,189,248,0.3)]' : 'bg-white/[0.05] hover:bg-white/[0.1] text-slate-300 border border-white/10 font-medium'"
                            class="px-4 py-2 rounded-xl text-xs sm:text-sm transition-all cursor-pointer">Pameran</button>
                </div>
            </div>

            {{-- Portfolio Grid with 3D Tilt --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-7 sm:gap-8 gsap-stagger-container">
                @foreach($portfolios as $port)
                <div x-show="activeCategory === 'All' || activeCategory === '{{ $port->category }}'"
                     x-transition
                     class="glass-panel card-3d-tilt rounded-3xl overflow-hidden hover:border-cyan-400/50 transition-all duration-300 gsap-stagger-item">

                    <div class="relative h-64 sm:h-80 overflow-hidden bg-slate-950">
                        <img src="{{ $port->thumbnail_url }}" alt="{{ $port->title }}"
                             class="w-full h-full object-cover transition-transform duration-700 hover:scale-105"
                             loading="lazy"
                             onerror="this.src='https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=800&q=80'">
                        <div class="absolute top-4 left-4">
                            <span class="px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-black/70 backdrop-blur-md text-white border border-white/20 uppercase shadow-lg">
                                {{ $port->category }}
                            </span>
                        </div>
                    </div>

                    <div class="p-7 space-y-3">
                        <h3 class="font-bold text-xl sm:text-2xl text-white font-serif italic">{{ $port->title }}</h3>
                        <p class="text-xs sm:text-sm text-slate-300 font-light leading-relaxed line-clamp-2">{{ $port->brief }}</p>

                        <div class="pt-4 border-t border-white/10 flex flex-wrap items-center justify-between gap-2 text-xs text-slate-400">
                            <span>📍 {{ $port->venue ?? 'Jabodetabek' }}</span>
                            <span class="font-semibold text-cyan-400">🎥 {{ $port->gear_used ?? 'Sony Cinema 4K' }}</span>
                        </div>
                    </div>

                </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ===================================================================
         SECTION 4: TECHNICAL STANDARDS & STUDIO BENCHMARKS
    =================================================================== --}}
    <section id="benchmark" class="py-20 sm:py-28 bg-[#070A12] text-white border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center max-w-3xl mx-auto mb-16 space-y-4 gsap-reveal">
                <span class="inline-block text-xs font-bold tracking-[0.25em] uppercase text-cyan-400">Mengapa Dezzly Creative</span>
                <h2 class="font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white">
                    Keunggulan & Jaminan Kualitas Studio
                </h2>
                <p class="text-base text-slate-400 font-light leading-relaxed">
                    Standar tinggi perlengkapan bioskop, legalitas pilot drone berlisensi, dan disiplin waktu yang membedakan karya kami.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-7 gsap-stagger-container">
                <div class="glass-panel card-3d-tilt p-8 rounded-3xl space-y-4 gsap-stagger-item">
                    <div class="w-12 h-12 rounded-2xl bg-cyan-950/70 border border-cyan-400/40 flex items-center justify-center text-2xl">🎥</div>
                    <h3 class="font-bold text-xl text-white">Kamera Full Frame Cinema Line</h3>
                    <p class="text-sm text-slate-400 font-light leading-relaxed">
                        Seluruh rekaman menggunakan sensor Full Frame Sony Alpha untuk dynamic range tinggi, ketajaman maksimal saat kondisi low-light panggung, dan depth-of-field sinematik.
                    </p>
                </div>

                <div class="glass-panel card-3d-tilt p-8 rounded-3xl space-y-4 gsap-stagger-item">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-950/70 border border-emerald-400/40 flex items-center justify-center text-2xl">🚁</div>
                    <h3 class="font-bold text-xl text-white">Pilot Drone 4K Berlisensi APDI</h3>
                    <p class="text-sm text-slate-400 font-light leading-relaxed">
                        Pilot drone kami memiliki sertifikasi resmi APDI, menjamin kepatuhan regulasi keselamatan penerbangan serta kestabilan manuver rekaman udara yang dramatis dan aman.
                    </p>
                </div>

                <div class="glass-panel card-3d-tilt p-8 rounded-3xl space-y-4 gsap-stagger-item">
                    <div class="w-12 h-12 rounded-2xl bg-purple-950/70 border border-purple-400/40 flex items-center justify-center text-2xl">🛡️</div>
                    <h3 class="font-bold text-xl text-white">Dual Recording Anti-Hilang</h3>
                    <p class="text-sm text-slate-400 font-light leading-relaxed">
                        Kamera kami merekam ke 2 slot SD Card secara simultan. Data visual Anda terproteksi secara instan dari risiko corrupt atau kegagalan kartu memori lapangan.
                    </p>
                </div>
            </div>

        </div>
    </section>

    {{-- ===================================================================
         SECTION 5: VIP RESERVATION & CONSULTATION DESK
    =================================================================== --}}
    <section id="booking" class="py-20 sm:py-28 bg-[#090D16] text-white border-b border-white/10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-12 space-y-4 gsap-reveal">
                <span class="inline-block text-xs font-bold tracking-[0.25em] uppercase text-cyan-400">Mulai Kolaborasi</span>
                <h2 class="font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white">
                    Konsultasi & Booking Jadwal Acara
                </h2>
                <p class="text-base text-slate-400 font-light max-w-xl mx-auto leading-relaxed">
                    Kirimkan detail rencana acara Anda di bawah ini. Tim Dezzly Creative akan merespons cepat via WhatsApp dengan penawaran resmi.
                </p>
            </div>

            <div class="glass-panel p-7 sm:p-12 rounded-3xl shadow-2xl gsap-reveal">
                <form @submit.prevent="submitDirectInquiry()" class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-slate-300 font-semibold text-sm mb-2">Nama Lengkap / Kontak Person:</label>
                            <input type="text" x-model="directForm.customer_name" required
                                   placeholder="Contoh: Rian Anggara"
                                   class="w-full bg-white/[0.04] border border-white/15 rounded-xl px-4 py-3.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400 transition-colors">
                        </div>
                        <div>
                            <label class="block text-slate-300 font-semibold text-sm mb-2">Nomor WhatsApp Aktif:</label>
                            <input type="text" x-model="directForm.customer_whatsapp" required
                                   placeholder="Contoh: 08123456789"
                                   class="w-full bg-white/[0.04] border border-white/15 rounded-xl px-4 py-3.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400 transition-colors">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-slate-300 font-semibold text-sm mb-2">Instansi / Perusahaan (Opsional):</label>
                            <input type="text" x-model="directForm.company_name"
                                   placeholder="Nama PT / Komunitas / Event Organizer"
                                   class="w-full bg-white/[0.04] border border-white/15 rounded-xl px-4 py-3.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400 transition-colors">
                        </div>
                        <div>
                            <label class="block text-slate-300 font-semibold text-sm mb-2">Pilihan Paket / Kategori Acara:</label>
                            <select x-model="directForm.package_id"
                                    class="w-full bg-[#0B0F19] border border-white/15 rounded-xl px-4 py-3.5 text-sm text-white focus:outline-none focus:border-cyan-400 transition-colors">
                                <option value="" class="bg-[#0B0F19]">-- Pilih Paket Layanan (Atau Kustom) --</option>
                                @foreach($packages as $pkg)
                                <option value="{{ $pkg->id }}" class="bg-[#0B0F19]">{{ $pkg->name }} ({{ $pkg->subtitle }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-slate-300 font-semibold text-sm mb-2">Tanggal Rencana Acara:</label>
                            <input type="date" x-model="directForm.event_date"
                                   class="w-full bg-white/[0.04] border border-white/15 rounded-xl px-4 py-3.5 text-sm text-white focus:outline-none focus:border-cyan-400 transition-colors">
                        </div>
                        <div>
                            <label class="block text-slate-300 font-semibold text-sm mb-2">Lokasi / Kota Acara:</label>
                            <input type="text" x-model="directForm.venue_location"
                                   placeholder="Contoh: ICE BSD / Hotel Mulia Jakarta"
                                   class="w-full bg-white/[0.04] border border-white/15 rounded-xl px-4 py-3.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400 transition-colors">
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-300 font-semibold text-sm mb-2">Kebutuhan Acara & Catatan Khusus:</label>
                        <textarea x-model="directForm.brief_notes" rows="3"
                                  placeholder="Ceritakan gambaran acara: durasi acara, kebutuhan drone, live streaming, atau request output khusus..."
                                  class="w-full bg-white/[0.04] border border-white/15 rounded-xl px-4 py-3.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400 transition-colors"></textarea>
                    </div>

                    <button type="submit"
                            :disabled="isSubmitting"
                            class="w-full py-4 rounded-xl bg-gradient-to-r from-sky-500 via-cyan-500 to-sky-600 hover:from-sky-400 hover:to-cyan-400 text-slate-950 font-extrabold text-sm uppercase tracking-widest shadow-[0_0_25px_rgba(56,189,248,0.35)] transition-all hover:scale-[1.01] active:scale-[0.98] disabled:opacity-50 cursor-pointer">
                        <span x-text="isSubmitting ? 'Mengirim Data...' : 'Kirim Konsultasi ke WhatsApp Dezzly Studio →'"></span>
                    </button>
                </form>
            </div>

        </div>
    </section>

    {{-- ===================================================================
         SECTION 6: FAQ ACCORDION
    =================================================================== --}}
    <section id="faq" class="py-20 sm:py-28 bg-[#070A12] text-white border-b border-white/10" x-data="{ activeFaq: null }">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-14 space-y-4 gsap-reveal">
                <span class="inline-block text-xs font-bold tracking-[0.25em] uppercase text-cyan-400">FAQ</span>
                <h2 class="font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white">
                    Pertanyaan yang Sering Diajukan
                </h2>
                <p class="text-base text-slate-400 font-light leading-relaxed">
                    Hal-hal penting seputar booking, durasi pengerjaan, dan output file dokumentasi acara.
                </p>
            </div>

            <div class="space-y-4">
                @foreach($faqs as $idx => $faq)
                <div class="glass-panel rounded-2xl overflow-hidden gsap-reveal">
                    <button type="button"
                            @click="activeFaq = (activeFaq === {{ $idx }}) ? null : {{ $idx }}"
                            class="w-full p-5 sm:p-6 text-left flex items-center justify-between gap-4 font-bold text-base sm:text-lg text-white cursor-pointer">
                        <span>{{ $faq->question }}</span>
                        <span class="text-xl font-bold transition-transform text-cyan-400"
                              :class="activeFaq === {{ $idx }} ? 'rotate-180' : ''">
                            ▾
                        </span>
                    </button>
                    <div x-show="activeFaq === {{ $idx }}"
                         x-transition
                         class="px-5 pb-6 sm:px-6 text-sm text-slate-300 font-light leading-relaxed border-t border-white/10 pt-4"
                         style="display: none;">
                        {!! nl2br(e($faq->answer)) !!}
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ===================================================================
         MODAL: INQUIRY POPUP DARI KARTU PAKET
    =================================================================== --}}
    <div x-show="isInquiryModalOpen"
         x-transition.opacity
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md"
         style="display: none;">
        <div @click.away="isInquiryModalOpen = false"
             class="glass-panel bg-[#0B0F19]/95 text-white p-7 sm:p-9 rounded-3xl max-w-lg w-full border border-white/15 shadow-2xl space-y-6 max-h-[90vh] overflow-y-auto">

            <div class="flex items-start justify-between border-b border-white/10 pb-5">
                <div>
                    <span class="text-xs font-bold text-cyan-400 uppercase tracking-widest">Konsultasi Paket Studio</span>
                    <h3 class="font-bold text-xl sm:text-2xl text-white font-serif italic mt-0.5" x-text="inquiryTarget.packageName"></h3>
                    <p class="text-xs font-medium text-emerald-400 mt-1">Penawaran resmi akan dikirim via WhatsApp</p>
                </div>
                <button type="button" @click="isInquiryModalOpen = false"
                        class="text-slate-400 hover:text-white text-2xl font-bold leading-none p-1 cursor-pointer">&#10005;</button>
            </div>

            <form @submit.prevent="submitModalInquiry()" class="space-y-4 text-sm">
                <div>
                    <label class="block text-slate-300 font-semibold mb-1.5">Nama Lengkap Anda:</label>
                    <input type="text" x-model="modalForm.customer_name" required
                           placeholder="Tuliskan nama Anda"
                           class="w-full bg-white/[0.04] border border-white/15 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400 transition-colors">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-slate-300 font-semibold mb-1.5">Nomor WhatsApp:</label>
                        <input type="text" x-model="modalForm.customer_whatsapp" required
                               placeholder="0812xxxxxxx"
                               class="w-full bg-white/[0.04] border border-white/15 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400 transition-colors">
                    </div>
                    <div>
                        <label class="block text-slate-300 font-semibold mb-1.5">Instansi / Kantor:</label>
                        <input type="text" x-model="modalForm.company_name"
                               placeholder="Opsional"
                               class="w-full bg-white/[0.04] border border-white/15 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400 transition-colors">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-slate-300 font-semibold mb-1.5">Tanggal Acara:</label>
                        <input type="date" x-model="modalForm.event_date"
                               class="w-full bg-white/[0.04] border border-white/15 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-cyan-400 transition-colors">
                    </div>
                    <div>
                        <label class="block text-slate-300 font-semibold mb-1.5">Lokasi Acara:</label>
                        <input type="text" x-model="modalForm.venue_location"
                               placeholder="Kota / Alamat"
                               class="w-full bg-white/[0.04] border border-white/15 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400 transition-colors">
                    </div>
                </div>

                <div>
                    <label class="block text-slate-300 font-semibold mb-1.5">Rencana Acara & Catatan Khusus:</label>
                    <textarea x-model="modalForm.brief_notes" rows="3"
                              placeholder="Tuliskan gambaran acara Anda..."
                              class="w-full bg-white/[0.04] border border-white/15 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400 transition-colors"></textarea>
                </div>

                <button type="submit"
                        :disabled="isSubmitting"
                        class="w-full py-4 rounded-xl bg-gradient-to-r from-sky-500 to-cyan-500 hover:from-sky-400 hover:to-cyan-400 text-slate-950 font-extrabold text-sm uppercase tracking-widest shadow-lg transition-all disabled:opacity-50 cursor-pointer">
                    <span x-text="isSubmitting ? 'Sedang Mengirim...' : 'Kirim ke WhatsApp Dezzly'"></span>
                </button>

                <div class="pt-2 text-center">
                    <button type="button"
                            @click="isInquiryModalOpen = false; if(window.openNegotiationChat) window.openNegotiationChat(inquiryTarget.packageId, inquiryTarget.packageName)"
                            class="text-xs text-cyan-400 hover:text-cyan-300 font-semibold underline cursor-pointer">
                        💬 Atau ingin tawar harga langsung? Buka Chat Negosiasi Studio
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

{{-- ===================================================================
     ALPINE JS LOGIC (EVENT STUDIO & DIRECT INQUIRY)
=================================================================== --}}
<script>
function dezzlyApp() {
    return {
        activeCategory: 'All',
        isSubmitting: false,
        isInquiryModalOpen: false,

        cameras: {{ \Illuminate\Support\Js::from($cameras) }},
        lenses: {{ \Illuminate\Support\Js::from($lenses) }},

        rentalForm: {
            rental_item_id: null,
            lens_item_id: '',
            start_date: '',
            duration_days: 1,
            customer_name: '',
            customer_whatsapp: '',
            notes: ''
        },
        isSubmittingRental: false,

        get selectedCamera() {
            return this.cameras.find(camera => camera.id === this.rentalForm.rental_item_id) || null;
        },

        get selectedLens() {
            return this.lenses.find(lens => lens.id === parseInt(this.rentalForm.lens_item_id, 10)) || null;
        },

        get rentalDailyTotal() {
            const cameraPrice = this.selectedCamera ? this.selectedCamera.daily_price : 0;
            const lensPrice = this.selectedLens ? this.selectedLens.daily_price : 0;
            return cameraPrice + lensPrice;
        },

        get rentalGrandTotal() {
            const days = parseInt(this.rentalForm.duration_days, 10) || 1;
            return this.rentalDailyTotal * days;
        },

        formatRupiah(value) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value || 0);
        },

        selectRentalCamera(cameraId) {
            this.rentalForm.rental_item_id = cameraId;
        },

        async submitRentalOrder() {
            if (!this.rentalForm.rental_item_id) {
                alert('Silakan pilih unit kamera terlebih dahulu.');
                return;
            }

            this.isSubmittingRental = true;
            try {
                const response = await fetch('{{ route('rental.order') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        rental_item_id: this.rentalForm.rental_item_id,
                        lens_item_id: this.rentalForm.lens_item_id || null,
                        start_date: this.rentalForm.start_date,
                        duration_days: this.rentalForm.duration_days,
                        customer_name: this.rentalForm.customer_name,
                        customer_whatsapp: this.rentalForm.customer_whatsapp,
                        notes: this.rentalForm.notes
                    })
                });
                const data = await response.json();
                if (!response.ok) {
                    const firstError = data.errors ? Object.values(data.errors)[0][0] : (data.message || 'Terjadi kesalahan pada data yang dikirim.');
                    alert(firstError);
                    return;
                }
                if (data.whatsapp_url) {
                    window.open(data.whatsapp_url, '_blank');
                    this.rentalForm = { rental_item_id: null, lens_item_id: '', start_date: '', duration_days: 1, customer_name: '', customer_whatsapp: '', notes: '' };
                }
            } catch (e) {
                alert('Terjadi kesalahan koneksi. Silakan coba lagi.');
            } finally {
                this.isSubmittingRental = false;
            }
        },

        inquiryTarget: {
            packageId: null,
            packageName: ''
        },

        directForm: {
            customer_name: '',
            customer_whatsapp: '',
            company_name: '',
            package_id: '',
            event_date: '',
            venue_location: '',
            brief_notes: ''
        },

        modalForm: {
            customer_name: '',
            customer_whatsapp: '',
            company_name: '',
            event_date: '',
            venue_location: '',
            brief_notes: ''
        },

        openInquiryModal(pkgId, name) {
            this.inquiryTarget.packageId = pkgId;
            this.inquiryTarget.packageName = name;
            this.modalForm.brief_notes = 'Saya tertarik dengan paket: ' + name;
            this.isInquiryModalOpen = true;
        },

        async submitModalInquiry() {
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
                        service_type: this.inquiryTarget.packageName || 'Konsultasi Paket',
                        customer_name: this.modalForm.customer_name,
                        customer_whatsapp: this.modalForm.customer_whatsapp,
                        company_name: this.modalForm.company_name,
                        event_date: this.modalForm.event_date,
                        venue_location: this.modalForm.venue_location,
                        brief_notes: this.modalForm.brief_notes
                    })
                });
                const data = await response.json();
                if (!response.ok) {
                    const firstError = data.errors ? Object.values(data.errors)[0][0] : (data.message || 'Terjadi kesalahan pada data yang dikirim.');
                    alert(firstError);
                    return;
                }
                if (data.whatsapp_url) {
                    window.open(data.whatsapp_url, '_blank');
                    this.isInquiryModalOpen = false;
                    this.modalForm = { customer_name: '', customer_whatsapp: '', company_name: '', event_date: '', venue_location: '', brief_notes: '' };
                }
            } catch (e) {
                alert('Terjadi kesalahan koneksi. Silakan coba lagi.');
            } finally {
                this.isSubmitting = false;
            }
        },

        async submitDirectInquiry() {
            this.isSubmitting = true;
            try {
                const response = await fetch('{{ route('service.inquiry') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        package_id: this.directForm.package_id || null,
                        service_type: 'Konsultasi Dokumentasi',
                        customer_name: this.directForm.customer_name,
                        customer_whatsapp: this.directForm.customer_whatsapp,
                        company_name: this.directForm.company_name,
                        event_date: this.directForm.event_date,
                        venue_location: this.directForm.venue_location,
                        brief_notes: this.directForm.brief_notes
                    })
                });
                const data = await response.json();
                if (!response.ok) {
                    const firstError = data.errors ? Object.values(data.errors)[0][0] : (data.message || 'Terjadi kesalahan pada data yang dikirim.');
                    alert(firstError);
                    return;
                }
                if (data.whatsapp_url) {
                    window.open(data.whatsapp_url, '_blank');
                    this.directForm = { customer_name: '', customer_whatsapp: '', company_name: '', package_id: '', event_date: '', venue_location: '', brief_notes: '' };
                }
            } catch (e) {
                alert('Terjadi kesalahan koneksi. Silakan coba lagi.');
            } finally {
                this.isSubmitting = false;
            }
        }
    }
}
</script>
@endsection
