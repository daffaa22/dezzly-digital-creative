<!DOCTYPE html>
<html lang="id" class="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'DEZZLY CREATIVE - Control Panel & Operasional Studio')</title>
    <meta name="robots" content="noindex, nofollow">

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    {{-- Anti-flash: apply saved theme BEFORE render --}}
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

<body
    class="bg-slate-100 dark:bg-slate-900 text-slate-900 dark:text-slate-100 min-h-screen flex flex-col font-sans antialiased"
    x-data="{
        isDark: document.documentElement.classList.contains('dark'),
        toggleTheme() {
            this.isDark = !this.isDark;
            document.documentElement.classList.toggle('dark', this.isDark);
            localStorage.setItem('dezzly-theme', this.isDark ? 'dark' : 'light');
        }
    }"
>

    {{-- ======= TOP ADMIN APP BAR (MANDIRI & TERISOLASI) ======= --}}
    <header class="sticky top-0 z-50 bg-white dark:bg-slate-800 border-b-2 border-slate-200 dark:border-slate-700 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-16 sm:h-20 flex items-center justify-between gap-4">

                {{-- Left: Brand & Control Panel Title --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group shrink-0">
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-[#0284C7] flex items-center justify-center font-extrabold text-white text-xl sm:text-2xl shadow-md group-hover:bg-[#0369A1] transition-colors">
                            D
                        </div>
                        <div>
                            <span class="font-extrabold text-lg sm:text-xl tracking-tight text-slate-900 dark:text-white block leading-tight">DEZZLY CREATIVE</span>
                            <span class="text-[10px] sm:text-xs font-extrabold tracking-widest text-[#0284C7] dark:text-sky-400 uppercase">INTERNAL CONTROL PANEL</span>
                        </div>
                    </a>

                    <div class="hidden md:flex items-center gap-2 ml-4 pl-4 border-l-2 border-slate-200 dark:border-slate-700">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/80 border border-emerald-300 dark:border-emerald-700 text-xs font-extrabold text-emerald-700 dark:text-emerald-300">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            PANEL MANDIRI AKTIF
                        </span>
                    </div>
                </div>

                {{-- Right: Actions & User Info --}}
                <div class="flex items-center gap-2 sm:gap-3">

                    {{-- Open Public Visitor Website Button --}}
                    <a href="{{ route('home') }}"
                       target="_blank"
                       class="inline-flex items-center gap-1.5 px-3 sm:px-4 py-2 rounded-xl bg-sky-50 hover:bg-sky-100 dark:bg-sky-950/60 dark:hover:bg-sky-900/60 border-2 border-sky-300 dark:border-sky-800 text-xs font-extrabold text-[#0284C7] dark:text-sky-300 transition-colors"
                       title="Buka Website Pengunjung di Tab Baru">
                        <span>🌐</span>
                        <span class="hidden sm:inline">Buka</span> Website Pengunjung &rarr;
                    </a>

                    {{-- Theme Toggle Button --}}
                    <button @click="toggleTheme()"
                            class="p-2 sm:p-2.5 rounded-xl border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-600 transition-all shrink-0 cursor-pointer"
                            :title="isDark ? 'Ganti ke Tema Terang' : 'Ganti ke Tema Gelap'">
                        <svg x-show="isDark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M18.364 17.657l-.707-.707M6.343 6.343l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <svg x-show="!isDark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>

                    {{-- User Profile Pill --}}
                    <div class="hidden lg:flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-700/60 border border-slate-300 dark:border-slate-600 text-xs font-bold text-slate-700 dark:text-slate-300">
                        <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                        <span>{{ Auth::user()->name ?? 'Dezzly Admin' }}</span>
                    </div>

                    {{-- Logout Button --}}
                    @auth
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="px-3 sm:px-4 py-2 rounded-xl bg-red-50 hover:bg-red-100 dark:bg-red-900/30 dark:hover:bg-red-900/50 border-2 border-red-300 dark:border-red-700 text-xs font-extrabold text-red-700 dark:text-red-300 transition-colors cursor-pointer">
                            Keluar
                        </button>
                    </form>
                    @endauth

                </div>
            </div>

            {{-- Sub-Navigation Tabs: Modul Operasional & Seluruh CMS --}}
            <div class="border-t border-slate-200 dark:border-slate-700">
                @include('admin.nav-tabs')
            </div>
        </div>
    </header>

    {{-- ======= MAIN CONTENT AREA ======= --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- ======= MINIMAL ADMIN FOOTER (NO VISITOR FOOTER, NO MEDIA WIDGET) ======= --}}
    <footer class="mt-auto bg-white dark:bg-slate-800 border-t-2 border-slate-200 dark:border-slate-700 py-5 text-xs text-slate-500 dark:text-slate-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span class="font-bold text-slate-700 dark:text-slate-300">DEZZLY CREATIVE STUDIO</span>
                <span>• Panel Kendali Operasional & CMS Mandiri</span>
            </div>
            <div class="text-[11px]">
                Sistem Terisolasi Mandiri (Bebas dari Clipper / Audio Player / Widget Visitor) • Laravel v{{ app()->version() }}
            </div>
        </div>
    </footer>

</body>
</html>
