@extends('layouts.app')

@section('title', 'DEZZLY CREATIVE — Jasa Dokumentasi Event, Drone & Rental Kamera Sony')

@section('content')
<div x-data="dezzlyApp()">

    <!-- ==================== HERO SECTION ==================== -->
    <section class="relative pt-12 pb-24 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto space-y-6">
                <!-- Top Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-cyan-500/30 bg-cyan-500/10 text-cyan-300 text-xs font-semibold tracking-wider uppercase backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
                    Solusi Dokumentasi Event & Rental Gear No. 1
                </div>

                <!-- Main Punchy Headline -->
                <h1 class="font-display font-extrabold text-4xl sm:text-6xl lg:text-7xl tracking-tight text-white leading-[1.1]">
                    Ciptakan Momen Epik.<br>
                    <span class="bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-500 bg-clip-text text-transparent">
                        Harga Transparan, Kualitas Tanpa Kompromi.
                    </span>
                </h1>

                <!-- Sub-copy -->
                <p class="text-base sm:text-lg text-slate-300 max-w-2xl mx-auto leading-relaxed">
                    Vendor dokumentasi foto, video aftermovie sinematik, pilot drone 4K, dan rental kamera Sony Alpha terlengkap. Siap mendukung event gathering, konser, pernikahan, hingga brand activation korporat.
                </p>

                <!-- Dual Action CTAs -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                    <a href="#services" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-slate-950 font-bold text-base shadow-xl shadow-cyan-500/20 transition-all hover:scale-105">
                        Lihat Paket Dokumentasi (Mulai 400K)
                    </a>
                    <a href="#rental" class="w-full sm:w-auto px-8 py-4 rounded-xl border border-slate-700 bg-slate-900/60 hover:bg-slate-800 text-white font-semibold text-base transition-all hover:border-cyan-500/50">
                        Sewa Kamera (Sony A6000 – A7C)
                    </a>
                </div>

                <!-- Key Metrics Bento Strip -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-12 text-left">
                    <div class="glass-panel p-5 rounded-2xl border-white/5">
                        <div class="text-2xl sm:text-3xl font-display font-bold text-cyan-400">250+</div>
                        <div class="text-xs text-slate-400 mt-1">Event Berhasil Tereksekusi</div>
                    </div>
                    <div class="glass-panel p-5 rounded-2xl border-white/5">
                        <div class="text-2xl sm:text-3xl font-display font-bold text-blue-400">Rp 750K</div>
                        <div class="text-xs text-slate-400 mt-1">Sudah Termasuk FG + VG + Drone</div>
                    </div>
                    <div class="glass-panel p-5 rounded-2xl border-white/5">
                        <div class="text-2xl sm:text-3xl font-display font-bold text-purple-400">4-5 Hari</div>
                        <div class="text-xs text-slate-400 mt-1">SLA Pengerjaan Edit Cepat</div>
                    </div>
                    <div class="glass-panel p-5 rounded-2xl border-white/5">
                        <div class="text-2xl sm:text-3xl font-display font-bold text-emerald-400">100%</div>
                        <div class="text-xs text-slate-400 mt-1">Sony Full Frame Gear Standar</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== SECTION 1: PAKET DOKUMENTASI ==================== -->
    <section id="services" class="py-20 border-t border-slate-800/60 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="text-cyan-400 text-xs font-bold tracking-widest uppercase">Paket Jasa Dokumentasi</span>
                <h2 class="font-display font-extrabold text-3xl sm:text-5xl text-white">
                    Pilihan Paket Foto, Video & Drone
                </h2>
                <p class="text-sm text-slate-400">
                    Transparansi penuh tanpa biaya tersembunyi. Dapatkan personil lengkap (FG + VG + Drone) dengan kamera bersensor Full Frame.
                </p>
            </div>

            <!-- Packages Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">
                @foreach($packages as $pkg)
                <div class="relative rounded-2xl transition-all duration-300 flex flex-col justify-between {{ $pkg->is_popular ? 'glass-panel-glow border-cyan-500/50 scale-[1.02] shadow-2xl shadow-cyan-500/10' : 'glass-panel border-white/5 hover:border-slate-700' }} p-6 sm:p-7">
                    
                    @if($pkg->is_popular)
                    <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-gradient-to-r from-cyan-500 to-blue-600 text-slate-950 font-bold text-xs tracking-wider uppercase shadow-md">
                        ⭐ Rekomendasi / Best Value
                    </div>
                    @endif

                    <div>
                        <!-- Header Card -->
                        <div class="border-b border-slate-800 pb-5">
                            <h3 class="font-display font-bold text-xl text-white">{{ $pkg->name }}</h3>
                            <p class="text-xs text-slate-400 mt-1">{{ $pkg->subtitle }}</p>
                            <div class="mt-4">
                                <span class="text-3xl font-display font-extrabold text-white">{{ $pkg->formatted_price }}</span>
                                @if($pkg->price_daily > 0)
                                <span class="text-xs text-slate-400">/ hari</span>
                                @endif
                            </div>
                        </div>

                        <!-- Key Specs Pills -->
                        <div class="py-4 space-y-2 text-xs">
                            <div class="flex items-center justify-between text-slate-300 bg-slate-900/60 px-3 py-1.5 rounded-lg border border-slate-800">
                                <span>Kamera Utama:</span>
                                <span class="font-semibold text-cyan-300 text-right">{{ $pkg->base_gear }}</span>
                            </div>
                            <div class="flex items-center justify-between text-slate-300 bg-slate-900/60 px-3 py-1.5 rounded-lg border border-slate-800">
                                <span>Cakupan Udara:</span>
                                <span class="font-semibold {{ $pkg->has_drone ? 'text-emerald-400' : 'text-slate-500' }}">
                                    {{ $pkg->has_drone ? '✅ Termasuk Drone 4K' : '❌ Tanpa Drone' }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-slate-300 bg-slate-900/60 px-3 py-1.5 rounded-lg border border-slate-800">
                                <span>Estimasi Selesai (SLA):</span>
                                <span class="font-semibold text-purple-300">{{ $pkg->turnaround_days }} Hari Kerja</span>
                            </div>
                        </div>

                        <!-- Features Checklist -->
                        <div class="pt-2 pb-6">
                            <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Benefit Layanan:</div>
                            <ul class="space-y-2.5 text-xs text-slate-300">
                                @if(!empty($pkg->features))
                                    @foreach($pkg->features as $feature)
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-cyan-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        <span>{{ $feature }}</span>
                                    </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- Bottom Action Button -->
                    <div>
                        <button type="button" 
                                @click="openInquiryModal({{ $pkg->id }}, '{{ $pkg->name }}', '{{ $pkg->formatted_price }}')"
                                class="w-full py-3 rounded-xl font-bold text-xs uppercase tracking-wider transition-all {{ $pkg->is_popular ? 'bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-slate-950 shadow-lg shadow-cyan-500/25' : 'border border-slate-700 bg-slate-900/90 hover:bg-slate-800 text-white hover:border-cyan-500' }}">
                            {{ $pkg->price_daily > 0 ? 'Pilih Paket Ini' : 'Minta Penawaran Kustom' }}
                        </button>
                    </div>

                </div>
                @endforeach
            </div>

            <!-- Pro-Tip Box -->
            <div class="mt-12 glass-panel p-6 rounded-2xl border-white/5 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 text-2xl shrink-0">
                        💡
                    </div>
                    <div>
                        <h4 class="text-white font-bold text-sm">Butuh Multi-Cam Siaran Langsung atau Event Skala Besar?</h4>
                        <p class="text-xs text-slate-400 mt-0.5">Kami menyediakan sistem switcher broadcast, streaming simultan ke Zoom/YouTube/IG, dan sound engineering.</p>
                    </div>
                </div>
                <button type="button" @click="openInquiryModal(null, 'Enterprise Multi-Cam & Live Streaming', 'Custom')" class="px-5 py-2.5 rounded-xl border border-purple-500/40 hover:bg-purple-500/10 text-purple-300 font-semibold text-xs whitespace-nowrap transition-colors">
                    Konsultasi Kustom
                </button>
            </div>
        </div>
    </section>

    <!-- ==================== SECTION 2: SMART CAMERA RENTAL ==================== -->
    <section id="rental" class="py-20 border-t border-slate-800/60 bg-[#090d14]/50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="text-blue-400 text-xs font-bold tracking-widest uppercase">Katalog & Kalkulator Sewa 24 Jam</span>
                <h2 class="font-display font-extrabold text-3xl sm:text-5xl text-white">
                    Sewa Kamera Sony Alpha & Lensa
                </h2>
                <p class="text-sm text-slate-400">
                    Pilih bodi kamera dan lensa sesuai kebutuhan. Sistem otomatis menghitung estimasi biaya sewa dan menyinkronkan ke WhatsApp Dezzly.
                </p>
            </div>

            <!-- Interactive Rental Engine Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left Column: Camera Selection Grid (7 Cols) -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-white font-bold text-base flex items-center gap-2">
                            <span>1. Pilih Bodi Kamera:</span>
                        </h3>
                        <span class="text-xs text-slate-400">Tarif per 24 Jam</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <template x-for="cam in cameras" :key="cam.id">
                            <div @click="selectCamera(cam)"
                                 :class="selectedCamera && selectedCamera.id === cam.id ? 'border-cyan-400 bg-cyan-950/20 shadow-lg shadow-cyan-500/10' : 'border-slate-800/80 bg-slate-900/60 hover:border-slate-700'"
                                 class="p-4 rounded-xl border cursor-pointer transition-all flex flex-col justify-between group">
                                <div>
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <h4 class="font-bold text-white text-sm group-hover:text-cyan-400 transition-colors" x-text="cam.name"></h4>
                                            <span class="inline-block text-[10px] font-semibold px-2 py-0.5 rounded mt-1" 
                                                  :class="cam.sensor_type === 'Full Frame' ? 'bg-purple-900/40 text-purple-300 border border-purple-500/30' : 'bg-slate-800 text-slate-300'"
                                                  x-text="cam.sensor_type"></span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-sm font-extrabold text-cyan-400" x-text="formatRupiah(cam.daily_price)"></span>
                                            <span class="text-[10px] text-slate-400 block">/ 24 Jam</span>
                                        </div>
                                    </div>
                                    <p class="text-[11px] text-slate-400 mt-2 line-clamp-2 leading-relaxed" x-text="cam.description"></p>
                                </div>

                                <div class="mt-3 pt-3 border-t border-slate-800/80 flex items-center justify-between text-[11px]">
                                    <span class="text-slate-400" x-text="cam.requires_fe_lens ? '⚠️ Wajib Lensa FE' : 'Lensa Kit / E-Mount'"></span>
                                    <span class="text-cyan-400 font-semibold" x-text="selectedCamera && selectedCamera.id === cam.id ? '✓ Dipilih' : '+ Pilih'"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Mandatory Lens Warning Notice -->
                    <div x-show="selectedCamera && selectedCamera.requires_fe_lens" x-transition class="p-4 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs flex items-start gap-3">
                        <span class="text-base">⚠️</span>
                        <div>
                            <span class="font-bold">Ketentuan Sewa Full Frame:</span>
                            <p class="text-amber-200/80 mt-0.5 leading-relaxed">
                                Kamera seri <strong x-text="selectedCamera ? selectedCamera.name : ''"></strong> (Full Frame) harus menyewa lensa tambahan seri Sony FE (Sony FE 50mm / Sony FE 28-70mm) agar sensor dapat bekerja optimal.
                            </p>
                        </div>
                    </div>

                    <!-- Lens Selection -->
                    <div class="pt-4 space-y-3">
                        <div class="flex items-center justify-between">
                            <h3 class="text-white font-bold text-base">2. Pilih Lensa Tambahan (Opsional/Wajib untuk FF):</h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <template x-for="lens in lenses" :key="lens.id">
                                <div @click="selectLens(lens)"
                                     :class="selectedLens && selectedLens.id === lens.id ? 'border-cyan-400 bg-cyan-950/20' : 'border-slate-800 bg-slate-900/60 hover:border-slate-700'"
                                     class="p-3 rounded-xl border cursor-pointer transition-all flex flex-col justify-between">
                                    <div>
                                        <div class="text-xs font-bold text-white" x-text="lens.name"></div>
                                        <span class="inline-block text-[9px] text-slate-400 mt-1" x-text="lens.mount_type"></span>
                                    </div>
                                    <div class="mt-2 pt-2 border-t border-slate-800 flex items-center justify-between text-[11px]">
                                        <span class="text-cyan-400 font-bold" x-text="formatRupiah(lens.daily_price)"></span>
                                        <span class="text-slate-400" x-text="selectedLens && selectedLens.id === lens.id ? '✓ Terpilih' : '+ Tambah'"></span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="pt-1 text-right" x-show="selectedLens">
                            <button type="button" @click="selectedLens = null" class="text-[11px] text-rose-400 hover:underline">
                                ✕ Batalkan Pilihan Lensa
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Interactive Booking Summary & Form (5 Cols) -->
                <div class="lg:col-span-5">
                    <div class="glass-panel p-6 sm:p-7 rounded-2xl border-white/10 sticky top-28 space-y-6">
                        <div class="border-b border-slate-800 pb-4">
                            <h3 class="font-display font-bold text-lg text-white">Ringkasan Sewa & Order</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Lengkapi formulir untuk langsung memvalidasi unit via WhatsApp.</p>
                        </div>

                        <!-- Calculation Breakdown -->
                        <div class="space-y-3 text-xs">
                            <div class="flex justify-between items-center text-slate-300">
                                <span>Bodi Kamera:</span>
                                <span class="font-semibold text-white" x-text="selectedCamera ? selectedCamera.name : 'Belum dipilih'"></span>
                            </div>
                            <div class="flex justify-between items-center text-slate-300">
                                <span>Tarif Kamera / 24 Jam:</span>
                                <span class="font-semibold text-cyan-400" x-text="selectedCamera ? formatRupiah(selectedCamera.daily_price) : 'Rp 0'"></span>
                            </div>
                            <div class="flex justify-between items-center text-slate-300">
                                <span>Lensa Tambahan:</span>
                                <span class="font-semibold text-white" x-text="selectedLens ? selectedLens.name : 'Tidak ada'"></span>
                            </div>
                            <div class="flex justify-between items-center text-slate-300">
                                <span>Tarif Lensa / 24 Jam:</span>
                                <span class="font-semibold text-cyan-400" x-text="selectedLens ? formatRupiah(selectedLens.daily_price) : 'Rp 0'"></span>
                            </div>

                            <!-- Duration Selector -->
                            <div class="pt-2 border-t border-slate-800">
                                <label class="block text-slate-300 font-semibold mb-1.5">Durasi Sewa:</label>
                                <div class="grid grid-cols-4 gap-2">
                                    <button type="button" @click="rentalDays = 1" :class="rentalDays === 1 ? 'bg-cyan-500 text-black font-bold' : 'bg-slate-800 text-slate-300'" class="py-1.5 rounded-lg text-xs transition-colors">1 Hari</button>
                                    <button type="button" @click="rentalDays = 2" :class="rentalDays === 2 ? 'bg-cyan-500 text-black font-bold' : 'bg-slate-800 text-slate-300'" class="py-1.5 rounded-lg text-xs transition-colors">2 Hari</button>
                                    <button type="button" @click="rentalDays = 3" :class="rentalDays === 3 ? 'bg-cyan-500 text-black font-bold' : 'bg-slate-800 text-slate-300'" class="py-1.5 rounded-lg text-xs transition-colors">3 Hari</button>
                                    <button type="button" @click="rentalDays = 7" :class="rentalDays === 7 ? 'bg-cyan-500 text-black font-bold' : 'bg-slate-800 text-slate-300'" class="py-1.5 rounded-lg text-xs transition-colors">1 Minggu</button>
                                </div>
                            </div>

                            <!-- Total Display -->
                            <div class="p-4 rounded-xl bg-slate-900/90 border border-slate-800 flex items-center justify-between mt-4">
                                <div>
                                    <span class="text-xs text-slate-400 block">Total Biaya Sewa:</span>
                                    <span class="text-xl font-display font-extrabold text-cyan-400" x-text="formatRupiah(calculateGrandTotal())"></span>
                                </div>
                                <span class="text-[11px] text-slate-400" x-text="rentalDays + ' Hari (x 24 Jam)'"></span>
                            </div>
                        </div>

                        <!-- Customer Details Form -->
                        <form @submit.prevent="submitRentalBooking()" class="space-y-4 pt-2">
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Nama Penyewa:</label>
                                <input type="text" x-model="rentalForm.customer_name" required placeholder="Contoh: Rian Pratama" class="w-full bg-slate-900/90 border border-slate-700 rounded-xl px-3.5 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Nomor WhatsApp Aktif:</label>
                                <input type="text" x-model="rentalForm.customer_whatsapp" required placeholder="0812xxxxxxx" class="w-full bg-slate-900/90 border border-slate-700 rounded-xl px-3.5 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Mulai Tanggal Sewa:</label>
                                <input type="date" x-model="rentalForm.start_date" required class="w-full bg-slate-900/90 border border-slate-700 rounded-xl px-3.5 py-2 text-xs text-white focus:outline-none focus:border-cyan-400">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Catatan Tambahan (Opsional):</label>
                                <input type="text" x-model="rentalForm.notes" placeholder="Lokasi pemakaian atau kebutuhan aksesoris..." class="w-full bg-slate-900/90 border border-slate-700 rounded-xl px-3.5 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400">
                            </div>

                            <button type="submit" 
                                    :disabled="isSubmitting || !selectedCamera"
                                    class="w-full py-3.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-slate-950 font-bold text-xs uppercase tracking-wider shadow-lg shadow-emerald-500/20 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                <span x-text="isSubmitting ? 'Memproses Booking...' : 'Booking via WhatsApp Sekarang'"></span>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ==================== SECTION 3: PORTOFOLIO ==================== -->
    <section id="portfolio" class="py-20 border-t border-slate-800/60 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div>
                    <span class="text-purple-400 text-xs font-bold tracking-widest uppercase">Karya & Rekam Jejak</span>
                    <h2 class="font-display font-extrabold text-3xl sm:text-5xl text-white mt-1">
                        Portofolio & Studi Kasus
                    </h2>
                    <p class="text-sm text-slate-400 mt-2 max-w-xl">
                        Lihat bagaimana kami mentransformasikan momen berharga menjadi mahakarya visual sinematik dengan gear kelas atas.
                    </p>
                </div>

                <!-- Category Filter Pills -->
                <div class="flex flex-wrap gap-2">
                    <button type="button" @click="activeCategory = 'All'" :class="activeCategory === 'All' ? 'bg-cyan-500 text-black font-bold' : 'bg-slate-900 text-slate-300 border border-slate-800'" class="px-4 py-2 rounded-xl text-xs transition-colors">Semua</button>
                    <button type="button" @click="activeCategory = 'Corporate'" :class="activeCategory === 'Corporate' ? 'bg-cyan-500 text-black font-bold' : 'bg-slate-900 text-slate-300 border border-slate-800'" class="px-4 py-2 rounded-xl text-xs transition-colors">Corporate</button>
                    <button type="button" @click="activeCategory = 'Concert & Show'" :class="activeCategory === 'Concert & Show' ? 'bg-cyan-500 text-black font-bold' : 'bg-slate-900 text-slate-300 border border-slate-800'" class="px-4 py-2 rounded-xl text-xs transition-colors">Concert & Show</button>
                    <button type="button" @click="activeCategory = 'Brand Activation'" :class="activeCategory === 'Brand Activation' ? 'bg-cyan-500 text-black font-bold' : 'bg-slate-900 text-slate-300 border border-slate-800'" class="px-4 py-2 rounded-xl text-xs transition-colors">Brand Activation</button>
                </div>
            </div>

            <!-- Portfolio Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($portfolios as $port)
                <div x-show="activeCategory === 'All' || activeCategory === '{{ $port->category }}'" 
                     x-transition 
                     class="glass-panel rounded-2xl overflow-hidden border border-white/5 hover:border-cyan-500/30 transition-all duration-300 group">
                    
                    <!-- Thumbnail Media Header -->
                    <div class="relative h-64 sm:h-72 overflow-hidden bg-slate-900">
                        <img src="{{ $port->thumbnail_url }}" alt="{{ $port->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#07090e] via-transparent to-black/30"></div>
                        
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-slate-900/80 backdrop-blur-md text-cyan-300 border border-cyan-500/30 uppercase">
                                {{ $port->category }}
                            </span>
                        </div>

                        <div class="absolute bottom-4 left-4 right-4">
                            <span class="text-xs text-cyan-400 font-semibold">{{ $port->client_name }}</span>
                            <h3 class="font-display font-bold text-xl sm:text-2xl text-white">{{ $port->title }}</h3>
                        </div>
                    </div>

                    <!-- Detail Body -->
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-2 text-xs border-b border-slate-800/80 pb-4">
                            <div>
                                <span class="text-slate-500 block">Venue:</span>
                                <span class="text-slate-200 font-medium">{{ $port->venue }}</span>
                            </div>
                            <div>
                                <span class="text-slate-500 block">Gear Digunakan:</span>
                                <span class="text-cyan-300 font-medium">{{ $port->gear_used }}</span>
                            </div>
                        </div>

                        <div class="text-xs text-slate-300 leading-relaxed">
                            <strong class="text-white block mb-1">Brief & Tantangan:</strong>
                            {{ $port->brief }}
                        </div>

                        <div class="p-3.5 rounded-xl bg-slate-900/70 border border-slate-800 text-xs text-slate-300">
                            <span class="text-purple-300 font-semibold block mb-0.5">Eksekusi & Hasil:</span>
                            {{ $port->execution_notes }}
                        </div>

                        <div class="pt-2 flex items-center justify-between text-xs">
                            <span class="text-slate-400">Skala Audiens: <strong class="text-white">{{ number_format($port->audience_count) }}+ Orang</strong></span>
                            <a href="https://wa.me/6281234567890?text=Halo%20Dezzly,%20saya%20tertarik%20dengan%20studi%20kasus%20{{ urlencode($port->title) }}" target="_blank" class="text-cyan-400 font-semibold hover:underline">
                                Minta Showreel Lengkap →
                            </a>
                        </div>
                    </div>

                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ==================== SECTION 4: BENCHMARK KEUNGGULAN ==================== -->
    <section id="benchmark" class="py-20 border-t border-slate-800/60 bg-[#090d14]/40 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="text-emerald-400 text-xs font-bold tracking-widest uppercase">Nilai Lebih Dezzly Creative</span>
                <h2 class="font-display font-extrabold text-3xl sm:text-5xl text-white">
                    Mengapa Dezzly Pilihan Paling Cerdas?
                </h2>
                <p class="text-sm text-slate-400">
                    Bandingkan standar penawaran kami dengan harga vendor dan agensi konvensional di pasar.
                </p>
            </div>

            <!-- Comparison Table -->
            <div class="glass-panel rounded-2xl overflow-x-auto border-white/5">
                <table class="w-full text-left text-xs text-slate-300">
                    <thead class="bg-slate-900/90 text-slate-400 uppercase tracking-wider border-b border-slate-800">
                        <tr>
                            <th class="p-4 sm:p-5">Parameter Layanan</th>
                            <th class="p-4 sm:p-5 text-cyan-400 font-extrabold bg-cyan-950/20 border-x border-cyan-500/20">Dezzly Creative</th>
                            <th class="p-4 sm:p-5">Vendor Biasa / Freelancer</th>
                            <th class="p-4 sm:p-5">Agensi Konvensional</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/80">
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-white">Investasi (1 FG + 1 VG + Drone)</td>
                            <td class="p-4 sm:p-5 font-extrabold text-cyan-400 bg-cyan-950/20 border-x border-cyan-500/20 text-sm">
                                Rp 750.000 – 850.000 / Hari
                            </td>
                            <td class="p-4 sm:p-5 text-slate-400">Rp 1.500.000 – 2.500.000 (Tanpa Drone)</td>
                            <td class="p-4 sm:p-5 text-slate-400">Rp 4.000.000 – 7.500.000</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-white">Kamera & Sensor</td>
                            <td class="p-4 sm:p-5 font-bold text-white bg-cyan-950/20 border-x border-cyan-500/20">
                                Sony Full Frame (A7II / A7C)
                            </td>
                            <td class="p-4 sm:p-5 text-slate-400">Kamera Standar / Crop Sensor</td>
                            <td class="p-4 sm:p-5 text-slate-400">Full Frame / Cinema</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-white">Drone Aerial 4K</td>
                            <td class="p-4 sm:p-5 font-bold text-emerald-400 bg-cyan-950/20 border-x border-cyan-500/20">
                                ✅ Termasuk di Paket Rp 750K
                            </td>
                            <td class="p-4 sm:p-5 text-slate-400">❌ Add-on Tambahan (+Rp 800K)</td>
                            <td class="p-4 sm:p-5 text-slate-400">✅ Termasuk (Harga Premium)</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-white">Turnaround / Waktu Edit Selesai</td>
                            <td class="p-4 sm:p-5 font-bold text-purple-300 bg-cyan-950/20 border-x border-cyan-500/20">
                                4 – 5 Hari Kerja (Fast SLA)
                            </td>
                            <td class="p-4 sm:p-5 text-slate-400">10 – 14 Hari Kerja</td>
                            <td class="p-4 sm:p-5 text-slate-400">7 – 10 Hari Kerja</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-white">Layanan Rental Gear Terintegrasi</td>
                            <td class="p-4 sm:p-5 font-bold text-white bg-cyan-950/20 border-x border-cyan-500/20">
                                ✅ Bisa Sewa Bodi & Lensa Tambahan
                            </td>
                            <td class="p-4 sm:p-5 text-slate-400">❌ Harus Cari Rental Lain</td>
                            <td class="p-4 sm:p-5 text-slate-400">❌ Khusus Internal Production</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- ==================== MODAL: INQUIRY JASA DOKUMENTASI ==================== -->
    <div x-show="isInquiryModalOpen" 
         x-transition.opacity 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
         style="display: none;">
        <div @click.away="isInquiryModalOpen = false" class="glass-panel p-6 sm:p-8 rounded-2xl max-w-lg w-full border border-white/10 space-y-5">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-xs font-semibold text-cyan-400 uppercase tracking-wider">Formulir Pemesanan</span>
                    <h3 class="font-display font-bold text-xl text-white" x-text="inquiryTarget.packageName"></h3>
                    <p class="text-xs text-slate-400" x-text="'Investasi: ' + inquiryTarget.packagePrice"></p>
                </div>
                <button type="button" @click="isInquiryModalOpen = false" class="text-slate-400 hover:text-white text-lg">✕</button>
            </div>

            <form @submit.prevent="submitServiceInquiry()" class="space-y-4 text-xs">
                <div>
                    <label class="block text-slate-300 font-semibold mb-1">Nama Lengkap / PIC:</label>
                    <input type="text" x-model="inquiryForm.customer_name" required placeholder="Contoh: Sarah Amanda" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2 text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-300 font-semibold mb-1">WhatsApp Aktif:</label>
                        <input type="text" x-model="inquiryForm.customer_whatsapp" required placeholder="0812xxxxxxx" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2 text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400">
                    </div>
                    <div>
                        <label class="block text-slate-300 font-semibold mb-1">Nama Perusahaan / Komunitas:</label>
                        <input type="text" x-model="inquiryForm.company_name" placeholder="Opsional" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2 text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-300 font-semibold mb-1">Rencana Tanggal Acara:</label>
                        <input type="date" x-model="inquiryForm.event_date" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2 text-white focus:outline-none focus:border-cyan-400">
                    </div>
                    <div>
                        <label class="block text-slate-300 font-semibold mb-1">Lokasi / Venue:</label>
                        <input type="text" x-model="inquiryForm.venue_location" placeholder="Kota / Nama Tempat" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2 text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400">
                    </div>
                </div>

                <div>
                    <label class="block text-slate-300 font-semibold mb-1">Brief Acara & Kebutuhan Khusus:</label>
                    <textarea x-model="inquiryForm.brief_notes" rows="3" placeholder="Jelaskan gambaran rundown, tema acara, atau kebutuhan siaran..." class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2 text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400"></textarea>
                </div>

                <button type="submit" 
                        :disabled="isSubmitting"
                        class="w-full py-3.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-slate-950 font-bold uppercase tracking-wider shadow-lg shadow-cyan-500/20 transition-all disabled:opacity-50">
                    <span x-text="isSubmitting ? 'Mengirim Data...' : 'Kirim Penawaran ke WhatsApp Dezzly'"></span>
                </button>
            </form>
        </div>
    </div>

</div>

<!-- Pass Database Data to AlpineJS -->
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
                // Select first camera by default (Sony A6000 or A7II)
                if (this.cameras.length > 0) {
                    this.selectedCamera = this.cameras[0];
                }
            },

            selectCamera(camera) {
                this.selectedCamera = camera;
                // If camera does not require FE lens and current lens is not compatible, keep it flexible
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
                if (this.selectedLens) {
                    daily += this.selectedLens.daily_price;
                }
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
                    alert('Silakan pilih kamera terlebih dahulu.');
                    return;
                }

                if (this.selectedCamera.requires_fe_lens && !this.selectedLens) {
                    alert('Perhatian: Kamera seri Sony A7 (Full Frame) wajib menyewa lensa tambahan (Sony FE 50mm / FE 28-70mm).');
                    return;
                }

                this.isSubmitting = true;
                try {
                    const response = await fetch('{{ route('rental.order') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            customer_name: this.rentalForm.customer_name,
                            customer_whatsapp: this.rentalForm.customer_whatsapp,
                            rental_item_id: this.selectedCamera.id,
                            lens_item_id: this.selectedLens ? this.selectedLens.id : null,
                            start_date: this.rentalForm.start_date,
                            duration_days: this.rentalDays,
                            notes: this.rentalForm.notes
                        })
                    });

                    const data = await response.json();
                    if (data.success && data.redirect_url) {
                        window.location.href = data.redirect_url;
                    } else {
                        alert(data.message || 'Gagal memproses booking sewa.');
                    }
                } catch (e) {
                    alert('Terjadi kendala jaringan.');
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
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            customer_name: this.inquiryForm.customer_name,
                            customer_whatsapp: this.inquiryForm.customer_whatsapp,
                            company_name: this.inquiryForm.company_name,
                            package_id: this.inquiryTarget.packageId,
                            service_type: this.inquiryTarget.packageName,
                            event_date: this.inquiryForm.event_date,
                            venue_location: this.inquiryForm.venue_location,
                            brief_notes: this.inquiryForm.brief_notes
                        })
                    });

                    const data = await response.json();
                    if (data.success && data.redirect_url) {
                        window.location.href = data.redirect_url;
                    } else {
                        alert(data.message || 'Gagal memproses inquiry.');
                    }
                } catch (e) {
                    alert('Terjadi kendala jaringan.');
                } finally {
                    this.isSubmitting = false;
                }
            }
        };
    }
</script>
@endsection
