<!DOCTYPE html>
<html lang="id" class="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'DEZZLY CREATIVE - Jasa Dokumentasi Event, Drone & Sewa Kamera Sony')</title>
    <meta name="description" content="Vendor terpercaya dokumentasi foto, video sinematik, penerbangan drone 4K dan sewa kamera Sony Alpha. Harga transparan, hasil terjamin.">

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

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- Body: Alpine scope for theme + mobile menu --}}
<body
    class="bg-[#F8FAFC] dark:bg-slate-900 text-slate-900 dark:text-slate-100 min-h-screen flex flex-col font-sans antialiased"
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

    {{-- ======= TOP STRIP ======= --}}
    <div class="bg-slate-900 dark:bg-slate-950 text-slate-300 dark:text-slate-400 text-xs sm:text-sm py-2 px-4 border-b border-slate-700">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-1">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 font-semibold text-emerald-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Studio Aktif & Siap Melayani
                </span>
                <span class="hidden sm:inline text-slate-600">•</span>
                <span class="hidden sm:inline text-slate-400">Dokumentasi Event & Sewa Kamera Terpercaya</span>
            </div>
            <div class="flex items-center gap-4 text-xs font-semibold">
                <a href="https://wa.me/6281234567890" target="_blank"
                   class="hover:text-emerald-400 transition-colors flex items-center gap-1.5 text-slate-300">
                    <svg class="w-3.5 h-3.5 text-emerald-400 fill-current" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.174.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564c.173.087.289.13.332.203.043.072.043.419-.101.824z"/>
                    </svg>
                    WhatsApp: <strong class="text-emerald-400">0812-3456-7890</strong>
                </a>
            </div>
        </div>
    </div>

    {{-- ======= NAVBAR ======= --}}
    <header class="sticky top-0 z-50 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b-2 border-slate-200 dark:border-slate-700 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-4">

            {{-- Brand --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 group shrink-0">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-[#0284C7] flex items-center justify-center font-extrabold text-white text-xl sm:text-2xl shadow-md group-hover:bg-[#0369A1] transition-colors">
                    D
                </div>
                <div class="hidden sm:block">
                    <span class="font-extrabold text-xl sm:text-2xl tracking-wide text-slate-900 dark:text-white block leading-tight">DEZZLY</span>
                    <span class="text-xs font-bold tracking-widest text-[#0284C7] uppercase">CREATIVE STUDIO</span>
                </div>
                <span class="sm:hidden font-extrabold text-lg text-slate-900 dark:text-white">DEZZLY</span>
            </a>

            {{-- Desktop Nav --}}
            <nav class="hidden md:flex items-center gap-6 lg:gap-8 text-sm font-bold text-slate-700 dark:text-slate-300">
                <a href="#services" class="hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors py-1">Paket Dokumentasi</a>
                <a href="#rental" class="hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors py-1">Sewa Kamera</a>
                <a href="#portfolio" class="hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors py-1">Portofolio</a>
                <a href="#benchmark" class="hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors py-1">Keunggulan</a>
            </nav>

            {{-- Right: CTAs + Theme Toggle + Hamburger --}}
            <div class="flex items-center gap-2 sm:gap-3">

                {{-- Admin Link (desktop) --}}
                <a href="{{ route('admin.dashboard') }}"
                   class="hidden lg:inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border-2 border-slate-200 dark:border-slate-600 hover:border-slate-400 dark:hover:border-slate-400 text-xs font-bold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Admin
                </a>

                {{-- Sewa Kamera CTA (desktop) --}}
                <a href="#rental"
                   class="hidden sm:inline-flex px-4 lg:px-6 py-2.5 rounded-xl bg-[#0284C7] hover:bg-[#0369A1] text-white font-extrabold text-sm shadow-md shadow-sky-600/20 transition-all hover:scale-[1.02] active:scale-[0.98]">
                    Sewa Kamera
                </a>

                {{-- Theme Toggle Button --}}
                <button @click="toggleTheme()"
                        class="p-2.5 rounded-xl border-2 border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-all shrink-0"
                        :title="isDark ? 'Ganti ke Tema Terang' : 'Ganti ke Tema Gelap'">
                    {{-- Sun (shown in dark mode) --}}
                    <svg x-show="isDark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M18.364 17.657l-.707-.707M6.343 6.343l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    {{-- Moon (shown in light mode) --}}
                    <svg x-show="!isDark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>

                {{-- Hamburger (mobile) --}}
                <button @click="mobileMenu = !mobileMenu"
                        class="md:hidden p-2.5 rounded-xl border-2 border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-all"
                        :aria-expanded="mobileMenu">
                    <svg x-show="!mobileMenu" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenu" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

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
                Paket Dokumentasi
            </a>
            <a href="#rental" @click="mobileMenu = false"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-bold text-slate-700 dark:text-slate-300 hover:bg-sky-50 dark:hover:bg-slate-800 hover:text-[#0284C7] transition-colors">
                Sewa Kamera & Lensa
            </a>
            <a href="#portfolio" @click="mobileMenu = false"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-bold text-slate-700 dark:text-slate-300 hover:bg-sky-50 dark:hover:bg-slate-800 hover:text-[#0284C7] transition-colors">
                Portofolio & Karya
            </a>
            <a href="#benchmark" @click="mobileMenu = false"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-bold text-slate-700 dark:text-slate-300 hover:bg-sky-50 dark:hover:bg-slate-800 hover:text-[#0284C7] transition-colors">
                Keunggulan Kami
            </a>
            <div class="pt-3 border-t border-slate-200 dark:border-slate-700 flex flex-col gap-2">
                <a href="#rental" @click="mobileMenu = false"
                   class="text-center px-6 py-3 rounded-xl bg-[#0284C7] hover:bg-[#0369A1] text-white font-extrabold text-sm transition-all">
                    Sewa Kamera Sekarang
                </a>
                <a href="{{ route('admin.dashboard') }}"
                   class="text-center px-6 py-3 rounded-xl border-2 border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-bold text-sm hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                    Panel Admin
                </a>
            </div>
        </div>
    </header>

    {{-- ======= MAIN CONTENT ======= --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- ======= FOOTER ======= --}}
    <footer class="border-t-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 py-12 sm:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-10">

            {{-- Brand --}}
            <div class="sm:col-span-2 lg:col-span-1 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#0284C7] flex items-center justify-center font-extrabold text-white text-lg">D</div>
                    <span class="font-extrabold text-xl text-slate-900 dark:text-white">DEZZLY CREATIVE</span>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    Penyedia resmi jasa foto, video sinematik, rekaman drone 4K, dan persewaan kamera Sony Alpha terlengkap dengan pelayanan ramah dan bergaransi.
                </p>
                <div class="text-xs text-slate-500 dark:text-slate-500 font-semibold pt-1">
                    &copy; {{ date('Y') }} Dezzly Creative Indonesia. Hak cipta dilindungi.
                </div>
            </div>

            {{-- Layanan --}}
            <div class="space-y-3">
                <h4 class="text-slate-900 dark:text-white font-extrabold text-sm tracking-wide uppercase">Pilihan Layanan</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#services" class="text-slate-600 dark:text-slate-400 hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors">Paket Standar (Sony A6000/A6400)</a></li>
                    <li><a href="#services" class="text-slate-600 dark:text-slate-400 hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors">Paket Menengah (Sony A7II + Drone)</a></li>
                    <li><a href="#services" class="text-slate-600 dark:text-slate-400 hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors">Paket Premium (Sony A7C + Drone)</a></li>
                    <li><a href="#services" class="text-slate-600 dark:text-slate-400 hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors">Siaran Langsung (Live Stream)</a></li>
                </ul>
            </div>

            {{-- Rental --}}
            <div class="space-y-3">
                <h4 class="text-slate-900 dark:text-white font-extrabold text-sm tracking-wide uppercase">Sewa Kamera 24 Jam</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#rental" class="text-slate-600 dark:text-slate-400 hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors">Sony A6000 & A6400 (Hemat)</a></li>
                    <li><a href="#rental" class="text-slate-600 dark:text-slate-400 hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors">Sony A7R, A7II, A7III, A7C (Full Frame)</a></li>
                    <li><a href="#rental" class="text-slate-600 dark:text-slate-400 hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors">Pilihan Lensa Sony FE & Sigma</a></li>
                    <li><a href="#rental" class="text-slate-600 dark:text-slate-400 hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors">Ketentuan & Syarat Sewa Mudah</a></li>
                </ul>
            </div>

            {{-- Kontak --}}
            <div class="space-y-3">
                <h4 class="text-slate-900 dark:text-white font-extrabold text-sm tracking-wide uppercase">Lokasi & Kontak</h4>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    Studio & Hub Operasional:<br>
                    <strong class="text-slate-800 dark:text-slate-300">Jabodetabek dan sekitarnya</strong>
                    <span class="block text-xs mt-1">(Siap melayani perjalanan luar kota)</span>
                </p>
                <a href="https://wa.me/6281234567890" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border-2 border-emerald-500 dark:border-emerald-600 text-emerald-800 dark:text-emerald-400 font-bold text-sm hover:bg-emerald-100 dark:hover:bg-emerald-900/50 transition-colors">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.174.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564c.173.087.289.13.332.203.043.072.043.419-.101.824z"/>
                    </svg>
                    WhatsApp: 0812-3456-7890
                </a>
            </div>
        </div>
    </footer>

    {{-- ======= FLOATING WHATSAPP CTA ======= --}}
    <a href="https://wa.me/6281234567890?text=Halo%20Dezzly%20Creative,%20saya%20ingin%20konsultasi%20kebutuhan%20dokumentasi%20atau%20sewa%20kamera"
       target="_blank"
       class="fixed bottom-5 right-5 z-50 flex items-center gap-3 bg-[#15803D] hover:bg-[#166534] text-white font-extrabold px-5 py-3.5 sm:px-6 sm:py-4 rounded-full shadow-2xl shadow-green-900/30 hover:scale-105 active:scale-95 transition-all border-2 border-white">
        <svg class="w-6 h-6 fill-current shrink-0" viewBox="0 0 24 24">
            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.174.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564c.173.087.289.13.332.203.043.072.043.419-.101.824z"/>
        </svg>
        <div class="hidden sm:block text-left">
            <span class="text-xs text-green-100 block font-semibold leading-tight">Butuh Bantuan?</span>
            <span class="text-sm font-extrabold leading-tight">Hubungi via WhatsApp</span>
        </div>
    </a>

</body>
</html>
