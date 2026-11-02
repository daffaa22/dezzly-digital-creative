<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'DEZZLY CREATIVE — Event Documentation, Drone & Camera Rental')</title>
    <meta name="description" content="Vendor profesional dokumentasi foto, video aftermovie, drone aerial 4K dan rental kamera Sony Alpha untuk event korporat, gathering, konser & brand activation.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Syne:wght@700;800&display=swap" rel="stylesheet">

    <!-- Scripts & Styles via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-display { font-family: 'Syne', sans-serif; }
    </style>
</head>
<body class="bg-[#07090e] text-slate-100 min-h-screen flex flex-col font-sans antialiased selection:bg-cyan-500 selection:text-black">

    <!-- Top Glow Header Ambient -->
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-48 bg-gradient-to-b from-cyan-500/10 via-purple-600/5 to-transparent blur-3xl pointer-events-none -z-10"></div>

    <!-- Navigation Bar -->
    <header class="sticky top-0 z-50 glass-panel border-b border-white/5 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-cyan-500 to-blue-600 flex items-center justify-center font-display font-extrabold text-black text-xl shadow-lg shadow-cyan-500/20 group-hover:scale-105 transition-transform">
                    D
                </div>
                <div>
                    <span class="font-display font-extrabold text-xl tracking-wider text-white">DEZZLY</span>
                    <span class="text-xs font-semibold tracking-widest text-cyan-400 block -mt-1 uppercase">CREATIVE STUDIO</span>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-300">
                <a href="#services" class="hover:text-cyan-400 transition-colors">Paket Dokumentasi</a>
                <a href="#rental" class="hover:text-cyan-400 transition-colors">Sewa Kamera & Gear</a>
                <a href="#portfolio" class="hover:text-cyan-400 transition-colors">Portofolio</a>
                <a href="#benchmark" class="hover:text-cyan-400 transition-colors">Keunggulan</a>
                <a href="#contact" class="hover:text-cyan-400 transition-colors">Hubungi Kami</a>
            </nav>

            <!-- Action CTAs -->
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-slate-700 hover:border-slate-500 text-xs text-slate-300 hover:text-white transition-colors">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Admin Panel
                </a>
                <a href="#rental" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-slate-950 font-bold text-sm shadow-lg shadow-cyan-500/25 transition-all hover:scale-[1.02] active:scale-[0.98]">
                    Booking Sewa
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-800/80 bg-[#05070a] py-16 text-slate-400 text-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-10">
            <!-- Brand Column -->
            <div class="md:col-span-1 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-cyan-500 to-blue-600 flex items-center justify-center font-display font-extrabold text-black text-sm">
                        D
                    </div>
                    <span class="font-display font-bold text-lg text-white">DEZZLY CREATIVE</span>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Solusi terpadu produksi visual event, dokumentasi video sinematik, penerbangan drone 4K, dan rental kamera profesional dengan harga paling kompetitif di Indonesia.
                </p>
                <div class="text-xs text-slate-500">
                    © {{ date('Y') }} Dezzly Creative. All rights reserved.
                </div>
            </div>

            <!-- Services Links -->
            <div class="space-y-3">
                <h4 class="text-white font-semibold text-sm tracking-wide uppercase">Layanan Kami</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="#services" class="hover:text-cyan-400 transition-colors">Paket Standar (Sony A6000/A6400)</a></li>
                    <li><a href="#services" class="hover:text-cyan-400 transition-colors">Paket Menengah (Sony A7II + Drone)</a></li>
                    <li><a href="#services" class="hover:text-cyan-400 transition-colors">Paket Premium (Sony A7C + Drone)</a></li>
                    <li><a href="#contact" class="hover:text-cyan-400 transition-colors">Enterprise Multi-Cam & Live Stream</a></li>
                </ul>
            </div>

            <!-- Rental Links -->
            <div class="space-y-3">
                <h4 class="text-white font-semibold text-sm tracking-wide uppercase">Sewa Gear 24 Jam</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="#rental" class="hover:text-cyan-400 transition-colors">Sony A6000 & A6400 (APS-C)</a></li>
                    <li><a href="#rental" class="hover:text-cyan-400 transition-colors">Sony A7R, A7II, A7III, A7C (Full Frame)</a></li>
                    <li><a href="#rental" class="hover:text-cyan-400 transition-colors">Lensa FE 50mm, FE 28-70mm, Sigma 16mm</a></li>
                    <li><a href="#rental" class="hover:text-cyan-400 transition-colors">Syarat & Ketentuan Sewa Kamera</a></li>
                </ul>
            </div>

            <!-- Direct Contact -->
            <div class="space-y-3">
                <h4 class="text-white font-semibold text-sm tracking-wide uppercase">Kantor & Kontak</h4>
                <p class="text-xs text-slate-400">
                    Studio & Rental Hub:<br>
                    Jabodetabek & Sekitarnya (Siap Luar Kota)
                </p>
                <div class="pt-1">
                    <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-2 text-xs text-emerald-400 hover:text-emerald-300 font-semibold">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.174.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564c.173.087.289.13.332.203.043.072.043.419-.101.824z"/></svg>
                        WhatsApp CS: +62 812-3456-7890
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp CTA -->
    <a href="https://wa.me/6281234567890?text=Halo%20Dezzly%20Creative,%20saya%20ingin%20konsultasi%20kebutuhan%20event%20dan%20sewa%20kamera" target="_blank" class="fixed bottom-6 right-6 z-50 flex items-center gap-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold px-4 py-3 rounded-full shadow-2xl shadow-emerald-500/30 hover:scale-105 active:scale-95 transition-all">
        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.174.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564c.173.087.289.13.332.203.043.072.043.419-.101.824z"/></svg>
        <span class="text-xs tracking-wide">Chat WhatsApp</span>
    </a>

</body>
</html>
