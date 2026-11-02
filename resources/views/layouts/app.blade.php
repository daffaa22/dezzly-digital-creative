<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'DEZZLY CREATIVE — Jasa Dokumentasi Event, Drone & Rental Kamera Sony')</title>
    <meta name="description" content="Vendor terpercaya dokumentasi foto, video sinematik, penerbangan drone 4K dan sewa kamera Sony Alpha dengan harga terjangkau dan kualitas tajam.">

    <!-- Fonts: Plus Jakarta Sans (Mudah & Nyaman Dibaca Segala Usia) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts & Styles via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F8FAFC] text-[#0F172A] min-h-screen flex flex-col font-sans antialiased text-base selection:bg-sky-200 selection:text-sky-900">

    <!-- Top Accessibility & Quick Contact Strip (Sangat Membantu Orang Tua) -->
    <div class="bg-[#0F172A] text-slate-200 text-xs sm:text-sm py-2 px-4 border-b border-slate-700">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-1">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 font-medium text-emerald-400">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                    Studio Aktif &amp; Siap Melayani
                </span>
                <span class="hidden sm:inline text-slate-500">•</span>
                <span class="text-slate-300">Dokumentasi Event &amp; Sewa Kamera Terpercaya</span>
            </div>
            <div class="flex items-center gap-4 text-xs font-semibold">
                <a href="https://wa.me/6281234567890" target="_blank" class="hover:text-emerald-400 transition-colors flex items-center gap-1 text-slate-100">
                    📞 WhatsApp CS: <strong class="text-emerald-300">0812-3456-7890</strong>
                </a>
            </div>
        </div>
    </div>

    <!-- Navigation Bar Utama (Bersih, Kontras Tinggi, Huruf Jelas) -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b-2 border-slate-200 shadow-sm transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-22 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-xl bg-[#0284C7] flex items-center justify-center font-extrabold text-white text-2xl shadow-md group-hover:bg-[#0369A1] transition-colors">
                    D
                </div>
                <div>
                    <span class="font-extrabold text-2xl tracking-wide text-slate-900 block leading-tight">DEZZLY</span>
                    <span class="text-xs font-bold tracking-widest text-[#0284C7] uppercase">CREATIVE STUDIO</span>
                </div>
            </a>

            <!-- Desktop Nav Links (Ukuran 16px Jelas & Kontras Tinggi) -->
            <nav class="hidden md:flex items-center gap-8 text-base font-bold text-slate-700">
                <a href="#services" class="hover:text-[#0284C7] transition-colors py-1">Paket Dokumentasi</a>
                <a href="#rental" class="hover:text-[#0284C7] transition-colors py-1">Sewa Kamera &amp; Lensa</a>
                <a href="#portfolio" class="hover:text-[#0284C7] transition-colors py-1">Hasil Portofolio</a>
                <a href="#benchmark" class="hover:text-[#0284C7] transition-colors py-1">Keunggulan Kami</a>
            </nav>

            <!-- Action CTAs -->
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border-2 border-slate-300 hover:border-slate-500 text-xs font-bold text-slate-700 hover:text-slate-900 transition-colors">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    Panel Admin
                </a>
                <a href="#rental" class="px-6 py-3 rounded-xl bg-[#0284C7] hover:bg-[#0369A1] text-white font-extrabold text-sm shadow-md shadow-sky-600/20 transition-all hover:scale-[1.02] active:scale-[0.98]">
                    Sewa Kamera Sekarang
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer Ramah & Terstruktur (Kontras Tinggi) -->
    <footer class="border-t-2 border-slate-200 bg-white py-16 text-slate-600 text-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-10">
            <!-- Brand Column -->
            <div class="md:col-span-1 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#0284C7] flex items-center justify-center font-extrabold text-white text-lg">
                        D
                    </div>
                    <span class="font-extrabold text-xl text-slate-900">DEZZLY CREATIVE</span>
                </div>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Penyedia resmi jasa foto, video sinematik, rekaman udara drone 4K, dan persewaan kamera Sony Alpha terlengkap dengan pelayanan ramah dan bergaransi.
                </p>
                <div class="text-xs text-slate-500 font-semibold pt-2">
                    © {{ date('Y') }} Dezzly Creative Indonesia. Hak cipta dilindungi.
                </div>
            </div>

            <!-- Services Links -->
            <div class="space-y-3">
                <h4 class="text-slate-900 font-extrabold text-base tracking-wide uppercase">Pilihan Layanan</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="#services" class="hover:text-[#0284C7] transition-colors">Paket Standar (Sony A6000/A6400)</a></li>
                    <li><a href="#services" class="hover:text-[#0284C7] transition-colors">Paket Menengah (Sony A7II + Drone)</a></li>
                    <li><a href="#services" class="hover:text-[#0284C7] transition-colors">Paket Premium (Sony A7C + Drone)</a></li>
                    <li><a href="#services" class="hover:text-[#0284C7] transition-colors">Layanan Siaran Langsung (Live Stream)</a></li>
                </ul>
            </div>

            <!-- Rental Links -->
            <div class="space-y-3">
                <h4 class="text-slate-900 font-extrabold text-base tracking-wide uppercase">Sewa Kamera 24 Jam</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="#rental" class="hover:text-[#0284C7] transition-colors">Sony A6000 &amp; A6400 (Hemat)</a></li>
                    <li><a href="#rental" class="hover:text-[#0284C7] transition-colors">Sony A7R, A7II, A7III, A7C (Full Frame)</a></li>
                    <li><a href="#rental" class="hover:text-[#0284C7] transition-colors">Pilihan Lensa Sony FE &amp; Sigma</a></li>
                    <li><a href="#rental" class="hover:text-[#0284C7] transition-colors">Ketentuan &amp; Syarat Sewa Mudah</a></li>
                </ul>
            </div>

            <!-- Direct Contact -->
            <div class="space-y-3">
                <h4 class="text-slate-900 font-extrabold text-base tracking-wide uppercase">Lokasi &amp; Kontak Resmi</h4>
                <p class="text-sm text-slate-700 leading-relaxed">
                    Studio &amp; Hub Operasional:<br>
                    <strong>Jabodetabek dan sekitarnya</strong> (Siap melayani perjalanan luar kota).
                </p>
                <div class="pt-2">
                    <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-50 border-2 border-emerald-500 text-emerald-800 font-bold text-sm hover:bg-emerald-100 transition-colors">
                        <span class="text-lg">💬</span>
                        Hubungi WhatsApp: 0812-3456-7890
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp CTA (Ukuran Besar, Mudah Ditekan oleh Lansia/Orang Tua) -->
    <a href="https://wa.me/6281234567890?text=Halo%20Dezzly%20Creative,%20saya%20ingin%20konsultasi%20kebutuhan%20dokumentasi%20atau%20sewa%20kamera" target="_blank" class="fixed bottom-6 right-6 z-50 flex items-center gap-3 bg-[#15803D] hover:bg-[#166534] text-white font-extrabold px-6 py-4 rounded-full shadow-2xl shadow-green-900/30 hover:scale-105 active:scale-95 transition-all border-2 border-white">
        <svg class="w-7 h-7 fill-current shrink-0" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.174.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564c.173.087.289.13.332.203.043.072.043.419-.101.824z"/></svg>
        <div class="text-left">
            <span class="text-xs uppercase tracking-wider text-green-100 block font-semibold leading-tight">Butuh Bantuan Cepat?</span>
            <span class="text-base font-extrabold leading-tight">Hubungi Kami di WhatsApp</span>
        </div>
    </a>

</body>
</html>
