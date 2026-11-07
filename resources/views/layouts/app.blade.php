<!DOCTYPE html>
<html lang="id" class="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'DEZZLY CREATIVE - Jasa Dokumentasi Event Sinematik & Drone 4K')</title>
    <meta name="description" content="Vendor resmi dokumentasi foto acara, video highlight sinematik 4K, dan pilot drone bersertifikat untuk gathering kantor, pernikahan, konser, dan festival resmi.">

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    {{-- OpenGraph & Social Media Sharing (WhatsApp / Facebook / LinkedIn) --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Dezzly Creative">
    <meta property="og:title" content="DEZZLY CREATIVE - Jasa Dokumentasi Event Sinematik & Drone 4K">
    <meta property="og:description" content="Vendor resmi dokumentasi foto/video sinematik, pilot drone 4K, dan live streaming multicam bergaransi di Jabodetabek & sekitarnya.">
    <meta property="og:image" content="{{ asset('images/og-banner.svg') }}">
    <meta property="og:url" content="{{ url()->current() }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="DEZZLY CREATIVE - Studio Dokumentasi & Produksi Sinematik">
    <meta name="twitter:description" content="Vendor resmi foto, video sinematik, drone 4K dan multimedia event production terpercaya.">
    <meta name="twitter:image" content="{{ asset('images/og-banner.svg') }}">

    {{-- Anti-flash: apply saved theme BEFORE render to prevent white flash --}}
    <script>
        (function () {
            var saved = localStorage.getItem('dezzly-theme');
            var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (saved === 'dark' || (!saved && prefersDark)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    {{-- Fonts: Plus Jakarta Sans (Modern Clean UI) & Cormorant Garamond (Editorial Luxury Serif) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- Body: Alpine scope for theme + mobile menu --}}
<body
    class="bg-[#F8FAFC] dark:bg-slate-900 text-slate-900 dark:text-slate-100 min-h-screen flex flex-col font-sans antialiased relative selection:bg-sky-200 dark:selection:bg-sky-900"
    x-data="{
        isDark: document.documentElement.classList.contains('dark'),
        mobileMenu: false,
        toggleTheme() {
            this.isDark = !this.isDark;
            document.documentElement.classList.toggle('dark', this.isDark);
            localStorage.setItem('dezzly-theme', this.isDark ? 'dark' : 'light');
        }
    }"
>

    {{-- Interactive Ambient Glow Spotlight Following Cursor --}}
    <div id="ambient-cursor-spotlight"></div>

    @php
        $studioName = \App\Models\SiteSetting::get('studio_name', 'DEZZLY CREATIVE');
        $studioTagline = \App\Models\SiteSetting::get('studio_tagline', 'CINEMATIC EVENT & MULTIMEDIA PRODUCTION');
        $waRaw = \App\Models\SiteSetting::get('whatsapp_number', '0821-4603-1398');
        $waDigits = preg_replace('/[^0-9]/', '', $waRaw);
        if (str_starts_with($waDigits, '0')) {
            $waIntl = '62' . substr($waDigits, 1);
        } else {
            $waIntl = $waDigits;
        }
    @endphp

    {{-- ======= TOP STRIP ======= --}}
    <div class="bg-slate-950 text-slate-300 text-xs sm:text-sm py-2 px-4 border-b border-white/5">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-1.5">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-2 font-semibold text-emerald-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse shadow-[0_0_8px_#34d399]"></span>
                    {{ \App\Models\SiteSetting::get('top_strip_status', 'Studio Aktif & Siap Melayani Event') }}
                </span>
                <span class="hidden sm:inline text-slate-700">•</span>
                <span class="hidden sm:inline text-slate-400 font-normal">{{ \App\Models\SiteSetting::get('top_strip_text', 'Dokumentasi Foto, Video Sinematik & Drone 4K Profesional') }}</span>
            </div>
            <div class="flex items-center gap-4 text-xs font-semibold">
                <a href="https://wa.me/{{ $waIntl }}" target="_blank"
                   class="hover:text-emerald-400 transition-colors flex items-center gap-1.5 text-slate-300">
                    <svg class="w-3.5 h-3.5 text-emerald-400 fill-current" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.174.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564c.173.087.289.13.332.203.043.072.043.419-.101.824z"/>
                    </svg>
                    WhatsApp: <strong class="text-emerald-400">{{ $waRaw }}</strong>
                </a>
            </div>
        </div>
    </div>

    {{-- ======= NAVBAR ======= --}}
    <header class="sticky top-0 z-50 bg-white/85 dark:bg-[#0B0F19]/85 backdrop-blur-xl border-b border-slate-200/80 dark:border-white/10 shadow-sm transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-4">

            {{-- Brand --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3.5 group shrink-0">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-gradient-to-tr from-sky-600 via-sky-500 to-cyan-400 flex items-center justify-center font-extrabold text-white text-xl sm:text-2xl shadow-[0_0_20px_rgba(2,132,199,0.35)] group-hover:scale-105 transition-all">
                    D
                </div>
                <div class="hidden sm:block">
                    <span class="font-extrabold text-xl sm:text-2xl tracking-tight text-slate-900 dark:text-white block leading-tight font-sans">{{ $studioName }}</span>
                    <span class="text-[9px] font-bold tracking-[0.25em] text-[#0284C7] dark:text-cyan-400 uppercase block">{{ $studioTagline }}</span>
                </div>
                <span class="sm:hidden font-extrabold text-lg text-slate-900 dark:text-white">{{ $studioName }}</span>
            </a>

            @if(request()->routeIs('login'))
                {{-- Login Context Navbar --}}
                <div class="flex items-center gap-2 sm:gap-3">
                    <a href="{{ route('home') }}"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 text-xs font-extrabold text-slate-800 dark:text-slate-200 transition-colors">
                        &larr; Website Utama
                    </a>

                    <button @click="toggleTheme()"
                            class="p-2.5 rounded-xl border-2 border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-all shrink-0 cursor-pointer"
                            :title="isDark ? 'Ganti ke Tema Terang' : 'Ganti ke Tema Gelap'">
                        <svg x-show="isDark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M18.364 17.657l-.707-.707M6.343 6.343l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <svg x-show="!isDark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>
                </div>

            @else
                {{-- Public Landing Desktop Nav (100% Focused on Creative Studio) --}}
                <nav class="hidden md:flex items-center gap-5 lg:gap-7 text-sm font-bold text-slate-700 dark:text-slate-300">
                    <a href="#services" class="hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors py-1">Paket Layanan</a>
                    <a href="#rental" class="hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors py-1">Sewa Kamera</a>
                    <a href="#portfolio" class="hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors py-1">Portofolio</a>
                    <a href="#workflow" class="hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors py-1">Alur Kerja</a>
                    <a href="#benchmark" class="hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors py-1">Keunggulan</a>
                    <a href="#faq" class="hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors py-1">FAQ</a>
                </nav>

                {{-- Public Right: CTAs + Theme Toggle + Hamburger --}}
                <div class="flex items-center gap-2 sm:gap-3">
                    <a href="{{ route('admin.dashboard') }}"
                       class="hidden lg:inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border border-slate-200 dark:border-white/10 hover:border-slate-300 dark:hover:border-white/20 bg-slate-50 dark:bg-white/[0.03] text-xs font-semibold text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition-all">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_8px_#34d399]"></span>
                        Studio Ops
                    </a>

                    <a href="#booking"
                       class="hidden sm:inline-flex px-5 lg:px-6 py-2.5 rounded-xl bg-gradient-to-r from-sky-600 to-cyan-600 hover:from-sky-500 hover:to-cyan-500 text-white font-bold text-sm shadow-[0_4px_20px_rgba(2,132,199,0.3)] transition-all hover:scale-[1.02] active:scale-[0.98]">
                        Konsultasi Event
                    </a>

                    {{-- Theme Toggle Button --}}
                    <button @click="toggleTheme()"
                            class="p-2.5 rounded-xl border border-slate-200 dark:border-white/10 bg-white/80 dark:bg-slate-900/80 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all shrink-0 cursor-pointer"
                            :title="isDark ? 'Ganti ke Tema Terang' : 'Ganti ke Tema Gelap'">
                        <svg x-show="isDark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M18.364 17.657l-.707-.707M6.343 6.343l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <svg x-show="!isDark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>

                    {{-- Hamburger (mobile) --}}
                    <button @click="mobileMenu = !mobileMenu"
                            class="md:hidden p-2.5 rounded-xl border border-slate-200 dark:border-white/10 bg-white/80 dark:bg-slate-900/80 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all cursor-pointer"
                            :aria-expanded="mobileMenu">
                        <svg x-show="!mobileMenu" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="mobileMenu" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif
        </div>

        @if(!request()->routeIs('login'))
        {{-- Mobile Menu Dropdown --}}
        <div x-show="mobileMenu"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden border-t-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-4 space-y-1"
             style="display:none;">
            <a href="#services" @click="mobileMenu = false"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-bold text-slate-700 dark:text-slate-300 hover:bg-sky-50 dark:hover:bg-slate-800 hover:text-[#0284C7] transition-colors">
                Paket Layanan
            </a>
            <a href="#rental" @click="mobileMenu = false"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-bold text-slate-700 dark:text-slate-300 hover:bg-sky-50 dark:hover:bg-slate-800 hover:text-[#0284C7] transition-colors">
                Sewa Kamera & Lensa
            </a>
            <a href="#portfolio" @click="mobileMenu = false"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-bold text-slate-700 dark:text-slate-300 hover:bg-sky-50 dark:hover:bg-slate-800 hover:text-[#0284C7] transition-colors">
                Portofolio Karya
            </a>
            <a href="#workflow" @click="mobileMenu = false"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-bold text-slate-700 dark:text-slate-300 hover:bg-sky-50 dark:hover:bg-slate-800 hover:text-[#0284C7] transition-colors">
                Alur Produksi
            </a>
            <a href="#benchmark" @click="mobileMenu = false"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-bold text-slate-700 dark:text-slate-300 hover:bg-sky-50 dark:hover:bg-slate-800 hover:text-[#0284C7] transition-colors">
                Keunggulan Kami
            </a>
            <a href="#faq" @click="mobileMenu = false"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-bold text-slate-700 dark:text-slate-300 hover:bg-sky-50 dark:hover:bg-slate-800 hover:text-[#0284C7] transition-colors">
                FAQ (Pertanyaan Umum)
            </a>
            <div class="pt-3 border-t border-slate-200 dark:border-slate-700 flex flex-col gap-2">
                <a href="#booking" @click="mobileMenu = false"
                   class="text-center px-6 py-3 rounded-xl bg-[#0284C7] hover:bg-[#0369A1] text-white font-extrabold text-sm transition-all">
                    Konsultasi & Booking Event
                </a>
                <a href="{{ route('admin.dashboard') }}"
                   class="text-center px-6 py-3 rounded-xl border-2 border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-bold text-sm hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                    Panel Admin
                </a>
            </div>
        </div>
        @endif
    </header>

    {{-- ======= MAIN CONTENT ======= --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- ======= FOOTER (CREATIVE STUDIO ONLY) ======= --}}
    <footer class="border-t-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 py-12 sm:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-10">

            {{-- Brand --}}
            <div class="sm:col-span-2 lg:col-span-1 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#0284C7] flex items-center justify-center font-extrabold text-white text-lg">D</div>
                    <div>
                        <span class="font-extrabold text-lg text-slate-900 dark:text-white block leading-tight">DEZZLY CREATIVE</span>
                        <span class="text-[10px] font-bold text-[#0284C7] tracking-wider uppercase">STUDIO PRODUKSI SINEMATIK</span>
                    </div>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    Vendor resmi dokumentasi foto acara resmi, video teaser sinematik, rekaman udara drone 4K, dan live streaming multicam beresolusi tinggi dengan pelayanan profesional.
                </p>
                <div class="text-xs text-slate-500 dark:text-slate-500 font-semibold pt-1">
                    &copy; {{ date('Y') }} Dezzly Creative Studio. Hak cipta dilindungi.
                </div>
            </div>

            {{-- Pilihan Layanan --}}
            <div class="space-y-3">
                <h4 class="text-slate-900 dark:text-white font-extrabold text-sm tracking-wide uppercase">Kategori Layanan</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#services" class="text-slate-600 dark:text-slate-400 hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors">Dokumentasi Corporate Gathering</a></li>
                    <li><a href="#services" class="text-slate-600 dark:text-slate-400 hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors">Konser Musik & Festival Panggung</a></li>
                    <li><a href="#services" class="text-slate-600 dark:text-slate-400 hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors">Wedding & Engagement Sinematik</a></li>
                    <li><a href="#services" class="text-slate-600 dark:text-slate-400 hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors">Brand Commercial & Video Profil</a></li>
                </ul>
            </div>

            {{-- Keahlian Teknis Studio --}}
            <div class="space-y-3">
                <h4 class="text-slate-900 dark:text-white font-extrabold text-sm tracking-wide uppercase">Keahlian Produksi</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#benchmark" class="text-slate-600 dark:text-slate-400 hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors">Kamera Full Frame Cinema Line</a></li>
                    <li><a href="#benchmark" class="text-slate-600 dark:text-slate-400 hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors">Pilot Drone 4K Bersertifikat APDI</a></li>
                    <li><a href="#workflow" class="text-slate-600 dark:text-slate-400 hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors">Color Grading & Sound Design</a></li>
                    <li><a href="#workflow" class="text-slate-600 dark:text-slate-400 hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors">Penyimpanan Aman Dual Slot SD</a></li>
                </ul>
            </div>

            {{-- Kontak --}}
            <div class="space-y-3">
                <h4 class="text-slate-900 dark:text-white font-extrabold text-sm tracking-wide uppercase">Lokasi & Kontak</h4>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    Studio & Hub Operasional:<br>
                    <strong class="text-slate-800 dark:text-slate-300">{{ \App\Models\SiteSetting::get('operational_area', 'Jabodetabek dan sekitarnya (Melayani Luar Kota)') }}</strong>
                </p>
                <a href="https://wa.me/{{ $waIntl }}" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border-2 border-emerald-500 dark:border-emerald-600 text-emerald-800 dark:text-emerald-400 font-bold text-sm hover:bg-emerald-100 dark:hover:bg-emerald-900/50 transition-colors">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.174.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564c.173.087.289.13.332.203.043.072.043.419-.101.824z"/>
                    </svg>
                    WhatsApp: {{ $waRaw }}
                </a>
            </div>
        </div>
    </footer>

    @unless(request()->routeIs('login'))
    {{-- ======= HIDDEN AUDIO ELEMENT ======= --}}
    <audio id="dezzly-bg-audio" preload="auto" loop class="hidden">
        <source src="{{ asset('audio/the-weeknd.wav') }}" type="audio/wav">
        <source src="{{ asset('audio/the-weeknd.mp3') }}" type="audio/mpeg">
    </audio>

    {{-- ======= FLOATING NEGOTIATION CHAT & WHATSAPP DOCK ======= --}}
    @include('components.negotiation-chat-widget')

    {{-- ======= FLOATING STUDIO MUSIC PLAYER: THE WEEKND VIBES ======= --}}
    <div id="music-player-widget"
         x-data="{
             isPlaying: false,
             volume: 0.8,
             minimized: false,
             promptVisible: true,
             init() {
                 if (window.dezzlyAudio) {
                     window.dezzlyAudio.setVolume(this.volume);
                 }
             },
             toggleMusic() {
                 if (window.dezzlyAudio) {
                     this.isPlaying = window.dezzlyAudio.togglePlay();
                 }
                 this.promptVisible = false;
             },
             updateVolume(val) {
                 this.volume = val;
                 if (window.dezzlyAudio) {
                     window.dezzlyAudio.setVolume(val);
                 }
             }
         }"
         class="fixed bottom-5 left-5 z-40 flex flex-col items-start select-none">

        {{-- First-time Music Invitation Bubble --}}
        <div x-show="promptVisible && !isPlaying"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             class="mb-2 bg-slate-950/90 backdrop-blur-xl text-white text-xs px-4 py-2.5 rounded-2xl border border-cyan-400/40 shadow-2xl flex items-center gap-2.5 max-w-xs">
            <span class="text-base animate-bounce shrink-0">🎵</span>
            <span class="leading-snug text-slate-200 font-medium">Nyalakan audio atmosfer studio The Weeknd untuk pengalaman sinematik!</span>
            <button @click="promptVisible = false" class="text-slate-400 hover:text-white font-bold p-1 shrink-0">&times;</button>
        </div>

        {{-- Main Player Capsule --}}
        <div class="glass-panel bg-white/90 dark:bg-slate-950/90 backdrop-blur-2xl border border-slate-200/80 dark:border-white/10 shadow-[0_15px_35px_rgba(0,0,0,0.15)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.6)] rounded-2xl p-3 flex items-center gap-3 transition-all">

            {{-- Spinning Vinyl Record Icon --}}
            <button @click="toggleMusic()"
                    class="relative w-11 h-11 rounded-full bg-gradient-to-tr from-slate-950 via-slate-900 to-cyan-950 border border-cyan-400/60 flex items-center justify-center shrink-0 shadow-lg group cursor-pointer"
                    :class="isPlaying ? 'animate-[spin_4s_linear_infinite]' : ''"
                    title="Putar / Jeda Musik">
                <div class="w-6 h-6 rounded-full border border-cyan-400/30 flex items-center justify-center">
                    <div class="w-2.5 h-2.5 rounded-full bg-cyan-400 shadow-[0_0_8px_#38bdf8]"></div>
                </div>
                <div class="absolute inset-0 rounded-full bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <span x-text="isPlaying ? '❚❚' : '▶'" class="text-white text-xs font-bold"></span>
                </div>
            </button>

            {{-- Track Details & Animated Visualizer --}}
            <div x-show="!minimized" x-transition class="flex flex-col pr-1">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-900 dark:text-white tracking-tight">The Weeknd</span>
                    <span class="text-[10px] font-semibold tracking-wider px-1.5 py-0.5 rounded bg-cyan-50 dark:bg-cyan-950/60 border border-cyan-500/20 text-cyan-700 dark:text-cyan-300">Blinding Lights Vibe</span>
                </div>

                <div class="flex items-center gap-3 mt-1.5">
                    <div class="flex items-end gap-1 h-5 w-12 shrink-0 py-0.5">
                        <span class="w-1 rounded-full bg-[#0284C7] wave-bar-1" :class="!isPlaying ? 'paused-wave' : ''"></span>
                        <span class="w-1 rounded-full bg-sky-400 wave-bar-2" :class="!isPlaying ? 'paused-wave' : ''"></span>
                        <span class="w-1 rounded-full bg-indigo-500 wave-bar-3" :class="!isPlaying ? 'paused-wave' : ''"></span>
                        <span class="w-1 rounded-full bg-emerald-400 wave-bar-4" :class="!isPlaying ? 'paused-wave' : ''"></span>
                    </div>

                    <button @click="toggleMusic()"
                            class="px-2.5 py-1 rounded-lg text-xs font-bold transition-all cursor-pointer"
                            :class="isPlaying ? 'bg-red-500/10 text-red-500 border border-red-500/30' : 'bg-[#0284C7] hover:bg-[#0369A1] text-white shadow-sm'">
                        <span x-text="isPlaying ? 'Jeda' : 'Putar Musik'"></span>
                    </button>

                    <div class="hidden sm:flex items-center gap-1.5 ml-1" title="Volume Musik">
                        <span class="text-[11px] text-slate-400">🔊</span>
                        <input type="range" min="0" max="1" step="0.05" x-model="volume" @input="updateVolume($event.target.value)"
                               class="w-12 h-1 bg-slate-200 dark:bg-slate-700 rounded-lg appearance-none cursor-pointer accent-[#0284C7]">
                    </div>
                </div>
            </div>

            <button @click="minimized = !minimized"
                    class="text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 text-xs p-1 cursor-pointer"
                    :title="minimized ? 'Perluas Pemutar' : 'Perkecil Pemutar'">
                <span x-text="minimized ? '»' : '«'"></span>
            </button>

        </div>
    </div>
    @endunless

</body>
</html>
