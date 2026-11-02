@extends('layouts.app')

@section('title', 'DEZZLY CREATIVE — Jasa Dokumentasi Event, Drone & Rental Kamera Sony')

@section('content')
<div x-data="dezzlyApp()">

    <!-- ==================== HERO SECTION (Ramah Penglihatan, Font Besar & Jelas) ==================== -->
    <section class="relative pt-12 pb-20 bg-gradient-to-b from-sky-50/60 via-white to-slate-50 border-b-2 border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto space-y-6">
                <!-- Top Badge -->
                <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full border-2 border-sky-300 bg-sky-100/70 text-sky-900 text-xs sm:text-sm font-extrabold tracking-wide uppercase">
                    <span class="w-2.5 h-2.5 rounded-full bg-sky-600"></span>
                    Vendor Resmi Dokumentasi Event &amp; Persewaan Kamera
                </div>

                <!-- Main Punchy Headline (Hitam Arang Tebal, Kontras Maksimal) -->
                <h1 class="font-extrabold text-3xl sm:text-5xl lg:text-6xl tracking-tight text-slate-900 leading-[1.2]">
                    Abadikan Setiap Momen Berharga.<br>
                    <span class="text-[#0284C7]">Hasil Tajam, Pelayanan Ramah &amp; Terpercaya.</span>
                </h1>

                <!-- Sub-copy (Ukuran 18px Sangat Nyaman Dibaca) -->
                <p class="text-base sm:text-xl text-slate-700 max-w-3xl mx-auto leading-relaxed">
                    Kami melayani kebutuhan dokumentasi foto, rekaman video beresolusi tinggi, pilot drone 4K, hingga persewaan kamera Sony Alpha untuk acara keluarga, pernikahan, gathering kantor, maupun konser resmi.
                </p>

                <!-- Dual Action CTAs (Tombol Besar & Mudah Ditekan) -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                    <a href="#services" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-[#0284C7] hover:bg-[#0369A1] text-white font-extrabold text-base shadow-lg shadow-sky-700/20 transition-all hover:scale-[1.02] active:scale-[0.98]">
                        Lihat Pilihan Paket Foto &amp; Video (Mulai 400K)
                    </a>
                    <a href="#rental" class="w-full sm:w-auto px-8 py-4 rounded-xl border-2 border-slate-300 bg-white hover:bg-slate-100 text-slate-800 font-extrabold text-base transition-all hover:border-[#0284C7]">
                        Persewaan Kamera Sony (24 Jam)
                    </a>
                </div>

                <!-- Key Metrics Bento Strip (Kotak Bersih, Angka Besar) -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-10 text-left">
                    <div class="card-clean p-6 rounded-2xl">
                        <div class="text-3xl sm:text-4xl font-extrabold text-[#0284C7]">250+</div>
                        <div class="text-sm font-bold text-slate-700 mt-1">Acara Sukses</div>
                        <div class="text-xs text-slate-500">Terdokumentasi rapi</div>
                    </div>
                    <div class="card-clean p-6 rounded-2xl">
                        <div class="text-3xl sm:text-4xl font-extrabold text-emerald-700">Rp 750K</div>
                        <div class="text-sm font-bold text-slate-700 mt-1">Lengkap dengan Drone</div>
                        <div class="text-xs text-slate-500">Fotografer + Videografer</div>
                    </div>
                    <div class="card-clean p-6 rounded-2xl">
                        <div class="text-3xl sm:text-4xl font-extrabold text-purple-700">4-5 Hari</div>
                        <div class="text-sm font-bold text-slate-700 mt-1">Hasil Cepat Selesai</div>
                        <div class="text-xs text-slate-500">Garansi waktu pengerjaan</div>
                    </div>
                    <div class="card-clean p-6 rounded-2xl">
                        <div class="text-3xl sm:text-4xl font-extrabold text-amber-700">100%</div>
                        <div class="text-sm font-bold text-slate-700 mt-1">Kamera Sony Asli</div>
                        <div class="text-xs text-slate-500">Sensor jernih Full Frame</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== SECTION 1: PAKET DOKUMENTASI ==================== -->
    <section id="services" class="py-20 bg-white border-b-2 border-slate-200 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="text-[#0284C7] text-sm font-extrabold tracking-widest uppercase">Paket Jasa Dokumentasi</span>
                <h2 class="font-extrabold text-3xl sm:text-4xl text-slate-900">
                    Pilihan Paket Foto, Video &amp; Rekaman Udara (Drone)
                </h2>
                <p class="text-base text-slate-600">
                    Harga jujur dan transparan tanpa biaya tambahan tersembunyi. Tim kami hadir tepat waktu dengan peralatan lengkap.
                </p>
            </div>

            <!-- Packages Grid (Kartu Bersih, Tulisan Besar, Kontras Tinggi) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">
                @foreach($packages as $pkg)
                <div class="relative rounded-2xl transition-all duration-300 flex flex-col justify-between p-7 {{ $pkg->is_popular ? 'card-clean-highlight scale-[1.02] shadow-xl' : 'card-clean hover:border-slate-400' }}">
                    
                    @if($pkg->is_popular)
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-5 py-1.5 rounded-full bg-[#0284C7] text-white font-extrabold text-xs tracking-wider uppercase shadow-md">
                        ★ PILIHAN PALING FAVORIT
                    </div>
                    @endif

                    <div>
                        <!-- Header Card -->
                        <div class="border-b-2 border-slate-100 pb-5">
                            <h3 class="font-extrabold text-2xl text-slate-900">{{ $pkg->name }}</h3>
                            <p class="text-sm font-medium text-slate-600 mt-1">{{ $pkg->subtitle }}</p>
                            <div class="mt-4">
                                <span class="text-3xl sm:text-4xl font-extrabold text-[#0284C7]">{{ $pkg->formatted_price }}</span>
                                @if($pkg->price_daily > 0)
                                <span class="text-sm font-bold text-slate-500">/ hari</span>
                                @endif
                            </div>
                        </div>

                        <!-- Key Specs Pills (Kotak Jelas) -->
                        <div class="py-4 space-y-2 text-xs sm:text-sm">
                            <div class="flex items-center justify-between text-slate-700 bg-slate-50 px-3 py-2 rounded-xl border border-slate-200">
                                <span class="font-medium">Kamera:</span>
                                <span class="font-bold text-slate-900 text-right">{{ $pkg->base_gear }}</span>
                            </div>
                            <div class="flex items-center justify-between text-slate-700 bg-slate-50 px-3 py-2 rounded-xl border border-slate-200">
                                <span class="font-medium">Rekaman Drone:</span>
                                <span class="font-bold {{ $pkg->has_drone ? 'text-emerald-700' : 'text-slate-500' }}">
                                    {{ $pkg->has_drone ? '✓ Termasuk Drone 4K' : '✕ Tanpa Drone' }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-slate-700 bg-slate-50 px-3 py-2 rounded-xl border border-slate-200">
                                <span class="font-medium">Waktu Selesai:</span>
                                <span class="font-bold text-purple-800">{{ $pkg->turnaround_days }} Hari Kerja</span>
                            </div>
                        </div>

                        <!-- Features Checklist -->
                        <div class="pt-2 pb-6">
                            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Fasilitas yang Didapat:</div>
                            <ul class="space-y-3 text-sm text-slate-700">
                                @if(!empty($pkg->features))
                                    @foreach($pkg->features as $feature)
                                    <li class="flex items-start gap-2.5">
                                        <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">✓</span>
                                        <span class="leading-snug">{{ $feature }}</span>
                                    </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- Bottom Action Button (Tinggi, Jelas & Nyaman Diklik) -->
                    <div>
                        <button type="button" 
                                @click="openInquiryModal({{ $pkg->id }}, '{{ $pkg->name }}', '{{ $pkg->formatted_price }}')"
                                class="w-full py-4 rounded-xl font-extrabold text-sm uppercase tracking-wider transition-all {{ $pkg->is_popular ? 'bg-[#0284C7] hover:bg-[#0369A1] text-white shadow-md' : 'bg-slate-100 hover:bg-slate-200 text-slate-800 border-2 border-slate-300 hover:border-slate-400' }}">
                            {{ $pkg->price_daily > 0 ? 'Pilih Paket Ini' : 'Minta Penawaran Khusus' }}
                        </button>
                    </div>

                </div>
                @endforeach
            </div>

            <!-- Box Konsultasi Acara Besar -->
            <div class="mt-14 card-clean p-8 rounded-2xl flex flex-col md:flex-row items-center justify-between gap-6 bg-sky-50/50 border-2 border-sky-200">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-[#0284C7] text-white flex items-center justify-center text-3xl shrink-0 shadow-md">
                        💡
                    </div>
                    <div>
                        <h4 class="text-slate-900 font-extrabold text-lg">Punya Rencana Acara Besar atau Butuh Siaran Langsung (Live)?</h4>
                        <p class="text-sm text-slate-600 mt-1">Kami menyediakan peralatan multicam, siaran langsung ke Zoom/YouTube/Instagram, dan sound system resmi.</p>
                    </div>
                </div>
                <button type="button" @click="openInquiryModal(null, 'Enterprise Multi-Cam & Live Streaming', 'Custom')" class="px-6 py-3.5 rounded-xl bg-white border-2 border-[#0284C7] text-[#0284C7] hover:bg-sky-50 font-extrabold text-sm whitespace-nowrap transition-colors shadow-sm">
                    Konsultasi Acara Besar →
                </button>
            </div>
        </div>
    </section>

    <!-- ==================== SECTION 2: SMART CAMERA RENTAL ==================== -->
    <section id="rental" class="py-20 bg-[#F8FAFC] border-b-2 border-slate-200 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="text-[#0284C7] text-sm font-extrabold tracking-widest uppercase">Persewaan Kamera 24 Jam</span>
                <h2 class="font-extrabold text-3xl sm:text-4xl text-slate-900">
                    Sewa Kamera Sony Alpha &amp; Lensa Tambahan
                </h2>
                <p class="text-base text-slate-600">
                    Pilih tipe kamera yang Anda inginkan. Biaya sewa akan dihitung secara otomatis dan dapat langsung dipesan melalui WhatsApp.
                </p>
            </div>

            <!-- Interactive Rental Engine Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left Column: Camera Selection Grid (7 Cols) -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-slate-900 font-extrabold text-lg flex items-center gap-2">
                            <span>Langkah 1: Pilih Tipe Kamera</span>
                        </h3>
                        <span class="text-xs font-bold text-slate-500 bg-slate-200 px-3 py-1 rounded-full">Harga untuk Durasi 24 Jam</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <template x-for="cam in cameras" :key="cam.id">
                            <div @click="selectCamera(cam)"
                                 :class="selectedCamera && selectedCamera.id === cam.id ? 'border-2 border-[#0284C7] bg-sky-50/70 shadow-md ring-2 ring-sky-200' : 'border-2 border-slate-200 bg-white hover:border-slate-300'"
                                 class="p-5 rounded-2xl cursor-pointer transition-all flex flex-col justify-between group">
                                <div>
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <h4 class="font-extrabold text-slate-900 text-base" x-text="cam.name"></h4>
                                            <span class="inline-block text-xs font-bold px-2.5 py-1 rounded-md mt-1" 
                                                  :class="cam.sensor_type === 'Full Frame' ? 'bg-purple-100 text-purple-900 border border-purple-300' : 'bg-slate-100 text-slate-700 border border-slate-200'"
                                                  x-text="cam.sensor_type"></span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-lg font-extrabold text-[#0284C7]" x-text="formatRupiah(cam.daily_price)"></span>
                                            <span class="text-xs font-semibold text-slate-500 block">/ 24 Jam</span>
                                        </div>
                                    </div>
                                    <p class="text-xs sm:text-sm text-slate-600 mt-2.5 leading-relaxed" x-text="cam.description"></p>
                                </div>

                                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                                    <span class="font-semibold text-slate-600" x-text="cam.requires_fe_lens ? '⚠️ Wajib Lensa Tambahan' : 'Sudah termasuk lensa kit'"></span>
                                    <span class="font-extrabold text-[#0284C7]" x-text="selectedCamera && selectedCamera.id === cam.id ? '✓ Sedang Dipilih' : '+ Klik untuk Pilih'"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Mandatory Lens Warning Notice (Jelas & Terbaca untuk Orang Tua) -->
                    <div x-show="selectedCamera && selectedCamera.requires_fe_lens" x-transition class="p-5 rounded-2xl bg-amber-50 border-2 border-amber-300 text-amber-900 text-sm flex items-start gap-4 shadow-sm">
                        <span class="text-2xl shrink-0">ℹ️</span>
                        <div>
                            <strong class="font-extrabold block text-base">Catatan Penting untuk Kamera Full Frame:</strong>
                            <p class="mt-1 leading-relaxed text-amber-800">
                                Kamera tipe <strong x-text="selectedCamera ? selectedCamera.name : ''"></strong> adalah kamera bersensor Full Frame (kualitas tajam). Kamera ini <strong>harus disewa bersama lensa tambahan</strong> (pilihan lensa Sony FE tersedia pada langkah ke-2 di bawah).
                            </p>
                        </div>
                    </div>

                    <!-- Lens Selection -->
                    <div class="pt-4 space-y-3">
                        <div class="flex items-center justify-between">
                            <h3 class="text-slate-900 font-extrabold text-lg">Langkah 2: Pilih Lensa Tambahan (Opsional / Wajib untuk Full Frame)</h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <template x-for="lens in lenses" :key="lens.id">
                                <div @click="selectLens(lens)"
                                     :class="selectedLens && selectedLens.id === lens.id ? 'border-2 border-[#0284C7] bg-sky-50 shadow-md ring-2 ring-sky-200' : 'border-2 border-slate-200 bg-white hover:border-slate-300'"
                                     class="p-4 rounded-xl cursor-pointer transition-all flex flex-col justify-between">
                                    <div>
                                        <div class="text-sm font-extrabold text-slate-900" x-text="lens.name"></div>
                                        <span class="inline-block text-xs font-semibold text-slate-500 mt-1" x-text="lens.mount_type"></span>
                                    </div>
                                    <div class="mt-3 pt-2 border-t border-slate-100 flex items-center justify-between text-xs">
                                        <span class="text-[#0284C7] font-extrabold" x-text="formatRupiah(lens.daily_price)"></span>
                                        <span class="font-bold text-slate-700" x-text="selectedLens && selectedLens.id === lens.id ? '✓ Dipilih' : '+ Tambah'"></span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="pt-1 text-right" x-show="selectedLens">
                            <button type="button" @click="selectedLens = null" class="text-xs font-bold text-red-600 hover:underline">
                                ✕ Batalkan Pilihan Lensa Tambahan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Interactive Booking Summary & Form (5 Cols) -->
                <div class="lg:col-span-5">
                    <div class="card-clean p-7 rounded-2xl sticky top-28 space-y-6">
                        <div class="border-b-2 border-slate-100 pb-4">
                            <h3 class="font-extrabold text-xl text-slate-900">Ringkasan Biaya Sewa</h3>
                            <p class="text-sm text-slate-500 mt-1">Periksa kembali pilihan Anda sebelum memesan.</p>
                        </div>

                        <!-- Calculation Breakdown -->
                        <div class="space-y-3.5 text-sm">
                            <div class="flex justify-between items-center text-slate-700">
                                <span class="font-medium">Kamera Pilihan:</span>
                                <strong class="text-slate-900 font-bold" x-text="selectedCamera ? selectedCamera.name : 'Belum dipilih'"></strong>
                            </div>
                            <div class="flex justify-between items-center text-slate-700">
                                <span class="font-medium">Tarif Kamera / 24 Jam:</span>
                                <strong class="text-[#0284C7] font-bold" x-text="selectedCamera ? formatRupiah(selectedCamera.daily_price) : 'Rp 0'"></strong>
                            </div>
                            <div class="flex justify-between items-center text-slate-700">
                                <span class="font-medium">Lensa Tambahan:</span>
                                <strong class="text-slate-900 font-bold" x-text="selectedLens ? selectedLens.name : 'Tidak ada'"></strong>
                            </div>
                            <div class="flex justify-between items-center text-slate-700">
                                <span class="font-medium">Tarif Lensa / 24 Jam:</span>
                                <strong class="text-[#0284C7] font-bold" x-text="selectedLens ? formatRupiah(selectedLens.daily_price) : 'Rp 0'"></strong>
                            </div>

                            <!-- Duration Selector (Tombol Besar & Jelas) -->
                            <div class="pt-3 border-t-2 border-slate-100">
                                <label class="block text-slate-900 font-bold mb-2">Pilih Berapa Lama Waktu Sewa:</label>
                                <div class="grid grid-cols-4 gap-2">
                                    <button type="button" @click="rentalDays = 1" :class="rentalDays === 1 ? 'bg-[#0284C7] text-white font-extrabold shadow-sm' : 'bg-slate-100 text-slate-800 border border-slate-300 font-bold'" class="py-2.5 rounded-xl text-xs sm:text-sm transition-colors">1 Hari</button>
                                    <button type="button" @click="rentalDays = 2" :class="rentalDays === 2 ? 'bg-[#0284C7] text-white font-extrabold shadow-sm' : 'bg-slate-100 text-slate-800 border border-slate-300 font-bold'" class="py-2.5 rounded-xl text-xs sm:text-sm transition-colors">2 Hari</button>
                                    <button type="button" @click="rentalDays = 3" :class="rentalDays === 3 ? 'bg-[#0284C7] text-white font-extrabold shadow-sm' : 'bg-slate-100 text-slate-800 border border-slate-300 font-bold'" class="py-2.5 rounded-xl text-xs sm:text-sm transition-colors">3 Hari</button>
                                    <button type="button" @click="rentalDays = 7" :class="rentalDays === 7 ? 'bg-[#0284C7] text-white font-extrabold shadow-sm' : 'bg-slate-100 text-slate-800 border border-slate-300 font-bold'" class="py-2.5 rounded-xl text-xs sm:text-sm transition-colors">1 Minggu</button>
                                </div>
                            </div>

                            <!-- Total Display (Besar & Jelas) -->
                            <div class="p-5 rounded-2xl bg-sky-50 border-2 border-sky-200 flex items-center justify-between mt-4">
                                <div>
                                    <span class="text-xs font-bold text-slate-600 block uppercase">Total Biaya Sewa:</span>
                                    <span class="text-2xl font-extrabold text-[#0284C7]" x-text="formatRupiah(calculateGrandTotal())"></span>
                                </div>
                                <span class="text-xs font-bold text-slate-600 bg-white px-3 py-1.5 rounded-lg border border-sky-200" x-text="rentalDays + ' Hari (x 24 Jam)'"></span>
                            </div>
                        </div>

                        <!-- Customer Details Form (Input Besar & Lapang) -->
                        <form @submit.prevent="submitRentalBooking()" class="space-y-4 pt-2">
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-1">Nama Lengkap Anda:</label>
                                <input type="text" x-model="rentalForm.customer_name" required placeholder="Tuliskan nama Anda di sini" class="w-full bg-white border-2 border-slate-300 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-none focus:border-[#0284C7]">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-1">Nomor WhatsApp Aktif:</label>
                                <input type="text" x-model="rentalForm.customer_whatsapp" required placeholder="Contoh: 081234567890" class="w-full bg-white border-2 border-slate-300 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-none focus:border-[#0284C7]">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-1">Mulai Tanggal Sewa:</label>
                                <input type="date" x-model="rentalForm.start_date" required class="w-full bg-white border-2 border-slate-300 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-none focus:border-[#0284C7]">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-1">Catatan Tambahan (Opsional):</label>
                                <input type="text" x-model="rentalForm.notes" placeholder="Lokasi pemakaian kamera..." class="w-full bg-white border-2 border-slate-300 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-none focus:border-[#0284C7]">
                            </div>

                            <button type="submit" 
                                    :disabled="isSubmitting || !selectedCamera"
                                    class="w-full py-4 rounded-xl bg-[#15803D] hover:bg-[#166534] text-white font-extrabold text-sm uppercase tracking-wide shadow-md transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                <span x-text="isSubmitting ? 'Sedang Memproses...' : 'Kirim Pemesanan via WhatsApp Sekarang'"></span>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ==================== SECTION 3: PORTOFOLIO ==================== -->
    <section id="portfolio" class="py-20 bg-white border-b-2 border-slate-200 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div>
                    <span class="text-[#0284C7] text-sm font-extrabold tracking-widest uppercase">Contoh Karya Kami</span>
                    <h2 class="font-extrabold text-3xl sm:text-4xl text-slate-900 mt-1">
                        Portofolio &amp; Pengalaman Acara
                    </h2>
                    <p class="text-base text-slate-600 mt-2 max-w-xl">
                        Kumpulan hasil dokumentasi acara resmi, perayaan komunitas, dan konser yang telah sukses diselesaikan dengan hasil memuaskan.
                    </p>
                </div>

                <!-- Category Filter Pills -->
                <div class="flex flex-wrap gap-2">
                    <button type="button" @click="activeCategory = 'All'" :class="activeCategory === 'All' ? 'bg-[#0284C7] text-white font-extrabold shadow-sm' : 'bg-slate-100 text-slate-800 border border-slate-300 font-bold'" class="px-5 py-2.5 rounded-xl text-sm transition-colors">Semua Kategori</button>
                    <button type="button" @click="activeCategory = 'Corporate'" :class="activeCategory === 'Corporate' ? 'bg-[#0284C7] text-white font-extrabold shadow-sm' : 'bg-slate-100 text-slate-800 border border-slate-300 font-bold'" class="px-5 py-2.5 rounded-xl text-sm transition-colors">Perusahaan / Kantor</button>
                    <button type="button" @click="activeCategory = 'Concert & Show'" :class="activeCategory === 'Concert & Show' ? 'bg-[#0284C7] text-white font-extrabold shadow-sm' : 'bg-slate-100 text-slate-800 border border-slate-300 font-bold'" class="px-5 py-2.5 rounded-xl text-sm transition-colors">Konser &amp; Panggung</button>
                    <button type="button" @click="activeCategory = 'Brand Activation'" :class="activeCategory === 'Brand Activation' ? 'bg-[#0284C7] text-white font-extrabold shadow-sm' : 'bg-slate-100 text-slate-800 border border-slate-300 font-bold'" class="px-5 py-2.5 rounded-xl text-sm transition-colors">Pameran &amp; Booth</button>
                </div>
            </div>

            <!-- Portfolio Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($portfolios as $port)
                <div x-show="activeCategory === 'All' || activeCategory === '{{ $port->category }}'" 
                     x-transition 
                     class="card-clean rounded-2xl overflow-hidden hover:border-[#0284C7] transition-all duration-300">
                    
                    <!-- Thumbnail Media Header -->
                    <div class="relative h-64 sm:h-72 overflow-hidden bg-slate-100">
                        <img src="{{ $port->thumbnail_url }}" alt="{{ $port->title }}" class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4">
                            <span class="px-3.5 py-1.5 rounded-lg text-xs font-extrabold bg-white/95 text-slate-900 border border-slate-200 uppercase shadow-sm">
                                {{ $port->category }}
                            </span>
                        </div>
                    </div>

                    <!-- Detail Body -->
                    <div class="p-6 space-y-4">
                        <div>
                            <span class="text-xs font-extrabold text-[#0284C7] uppercase">{{ $port->client_name }}</span>
                            <h3 class="font-extrabold text-xl sm:text-2xl text-slate-900 mt-0.5">{{ $port->title }}</h3>
                        </div>

                        <div class="grid grid-cols-2 gap-3 text-xs sm:text-sm bg-slate-50 p-4 rounded-xl border border-slate-200">
                            <div>
                                <span class="text-slate-500 block font-medium">Tempat Acara:</span>
                                <strong class="text-slate-900 font-bold">{{ $port->venue }}</strong>
                            </div>
                            <div>
                                <span class="text-slate-500 block font-medium">Kamera Digunakan:</span>
                                <strong class="text-[#0284C7] font-bold">{{ $port->gear_used }}</strong>
                            </div>
                        </div>

                        <div class="text-sm text-slate-700 leading-relaxed">
                            <strong class="text-slate-900 block mb-1">Tujuan &amp; Kebutuhan:</strong>
                            {{ $port->brief }}
                        </div>

                        <div class="p-4 rounded-xl bg-sky-50 border border-sky-200 text-sm text-slate-800">
                            <strong class="text-[#0284C7] block mb-1">Hasil Eksekusi:</strong>
                            {{ $port->execution_notes }}
                        </div>

                        <div class="pt-2 flex items-center justify-between text-sm">
                            <span class="text-slate-600 font-medium">Jumlah Peserta: <strong class="text-slate-900">{{ number_format($port->audience_count) }}+ Orang</strong></span>
                            <a href="https://wa.me/6281234567890?text=Halo%20Dezzly,%20saya%20tertarik%20dengan%20studi%20kasus%20{{ urlencode($port->title) }}" target="_blank" class="text-[#0284C7] font-extrabold hover:underline">
                                Tanya Video Hasil Acara →
                            </a>
                        </div>
                    </div>

                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ==================== SECTION 4: BENCHMARK KEUNGGULAN ==================== -->
    <section id="benchmark" class="py-20 bg-[#F8FAFC] border-b-2 border-slate-200 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="text-emerald-700 text-sm font-extrabold tracking-widest uppercase">Perbandingan Biaya &amp; Kualitas</span>
                <h2 class="font-extrabold text-3xl sm:text-4xl text-slate-900">
                    Mengapa Dezzly Pilihan Paling Nyaman &amp; Hemat?
                </h2>
                <p class="text-base text-slate-600">
                    Bandingkan fasilitas paket lengkap kami dengan harga pasar pada umumnya.
                </p>
            </div>

            <!-- Comparison Table (Tabel Terbaca Sangat Jelas) -->
            <div class="card-clean rounded-2xl overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-700">
                    <thead class="bg-slate-100 text-slate-800 uppercase tracking-wider border-b-2 border-slate-200 font-extrabold">
                        <tr>
                            <th class="p-5">Fasilitas yang Didapat</th>
                            <th class="p-5 text-[#0284C7] font-extrabold bg-sky-50 border-x-2 border-sky-200">Dezzly Creative</th>
                            <th class="p-5">Vendor Lepas Biasa</th>
                            <th class="p-5">Agensi Konvensional</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-slate-100">
                        <tr>
                            <td class="p-5 font-bold text-slate-900">Biaya Lengkap (Fotografer + Videografer + Drone)</td>
                            <td class="p-5 font-extrabold text-[#0284C7] bg-sky-50 border-x-2 border-sky-200 text-base">
                                Rp 750.000 – 850.000 / Hari
                            </td>
                            <td class="p-5 text-slate-600">Rp 1.500.000 – 2.500.000 (Belum ada drone)</td>
                            <td class="p-5 text-slate-600">Rp 4.000.000 – 7.500.000</td>
                        </tr>
                        <tr>
                            <td class="p-5 font-bold text-slate-900">Tipe Sensor Kamera</td>
                            <td class="p-5 font-bold text-slate-900 bg-sky-50 border-x-2 border-sky-200">
                                Sony Full Frame (Hasil Tajam &amp; Bersih)
                            </td>
                            <td class="p-5 text-slate-600">Kamera Standar Pemula</td>
                            <td class="p-5 text-slate-600">Full Frame</td>
                        </tr>
                        <tr>
                            <td class="p-5 font-bold text-slate-900">Rekaman Udara Drone 4K</td>
                            <td class="p-5 font-bold text-emerald-700 bg-sky-50 border-x-2 border-sky-200">
                                ✓ Sudah Termasuk di Paket Rp 750.000
                            </td>
                            <td class="p-5 text-slate-600">✕ Biaya Tambahan (+Rp 800.000)</td>
                            <td class="p-5 text-slate-600">✓ Termasuk (Harga Mahal)</td>
                        </tr>
                        <tr>
                            <td class="p-5 font-bold text-slate-900">Kecepatan Selesai Edit</td>
                            <td class="p-5 font-bold text-purple-900 bg-sky-50 border-x-2 border-sky-200">
                                4 – 5 Hari Kerja (Cepat &amp; Bergaransi)
                            </td>
                            <td class="p-5 text-slate-600">10 – 14 Hari Kerja</td>
                            <td class="p-5 text-slate-600">7 – 10 Hari Kerja</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- ==================== MODAL: INQUIRY JASA DOKUMENTASI ==================== -->
    <div x-show="isInquiryModalOpen" 
         x-transition.opacity 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         style="display: none;">
        <div @click.away="isInquiryModalOpen = false" class="bg-white p-7 sm:p-8 rounded-2xl max-w-lg w-full border-2 border-slate-300 shadow-2xl space-y-5">
            <div class="flex items-start justify-between border-b-2 border-slate-100 pb-4">
                <div>
                    <span class="text-xs font-extrabold text-[#0284C7] uppercase tracking-wider">Formulir Pemesanan Layanan</span>
                    <h3 class="font-extrabold text-2xl text-slate-900" x-text="inquiryTarget.packageName"></h3>
                    <p class="text-sm font-bold text-emerald-700 mt-0.5" x-text="'Investasi: ' + inquiryTarget.packagePrice"></p>
                </div>
                <button type="button" @click="isInquiryModalOpen = false" class="text-slate-400 hover:text-slate-800 text-2xl font-bold">✕</button>
            </div>

            <form @submit.prevent="submitServiceInquiry()" class="space-y-4 text-sm">
                <div>
                    <label class="block text-slate-800 font-bold mb-1">Nama Lengkap Anda:</label>
                    <input type="text" x-model="inquiryForm.customer_name" required placeholder="Tuliskan nama Anda" class="w-full bg-white border-2 border-slate-300 rounded-xl px-4 py-2.5 text-slate-900 focus:outline-none focus:border-[#0284C7]">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-800 font-bold mb-1">Nomor WhatsApp:</label>
                        <input type="text" x-model="inquiryForm.customer_whatsapp" required placeholder="0812xxxxxxx" class="w-full bg-white border-2 border-slate-300 rounded-xl px-4 py-2.5 text-slate-900 focus:outline-none focus:border-[#0284C7]">
                    </div>
                    <div>
                        <label class="block text-slate-800 font-bold mb-1">Nama Instansi / Kantor:</label>
                        <input type="text" x-model="inquiryForm.company_name" placeholder="Opsional" class="w-full bg-white border-2 border-slate-300 rounded-xl px-4 py-2.5 text-slate-900 focus:outline-none focus:border-[#0284C7]">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-800 font-bold mb-1">Tanggal Acara:</label>
                        <input type="date" x-model="inquiryForm.event_date" class="w-full bg-white border-2 border-slate-300 rounded-xl px-4 py-2.5 text-slate-900 focus:outline-none focus:border-[#0284C7]">
                    </div>
                    <div>
                        <label class="block text-slate-800 font-bold mb-1">Lokasi / Tempat Acara:</label>
                        <input type="text" x-model="inquiryForm.venue_location" placeholder="Kota / Alamat Acara" class="w-full bg-white border-2 border-slate-300 rounded-xl px-4 py-2.5 text-slate-900 focus:outline-none focus:border-[#0284C7]">
                    </div>
                </div>

                <div>
                    <label class="block text-slate-800 font-bold mb-1">Rencana Acara &amp; Kebutuhan:</label>
                    <textarea x-model="inquiryForm.brief_notes" rows="3" placeholder="Tuliskan gambaran acara Anda..." class="w-full bg-white border-2 border-slate-300 rounded-xl px-4 py-2.5 text-slate-900 focus:outline-none focus:border-[#0284C7]"></textarea>
                </div>

                <button type="submit" 
                        :disabled="isSubmitting"
                        class="w-full py-4 rounded-xl bg-[#0284C7] hover:bg-[#0369A1] text-white font-extrabold text-sm uppercase tracking-wide shadow-md transition-all disabled:opacity-50">
                    <span x-text="isSubmitting ? 'Sedang Mengirim...' : 'Kirim Pemesanan ke WhatsApp Dezzly'"></span>
                </button>
            </form>
        </div>
    </div>

</div>

<!-- AlpineJS Data Logic -->
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
                    alert('Silakan pilih salah satu kamera terlebih dahulu.');
                    return;
                }

                if (this.selectedCamera.requires_fe_lens && !this.selectedLens) {
                    alert('Perhatian: Kamera Full Frame wajib menyewa lensa tambahan (Sony FE 50mm / FE 28-70mm).');
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
                        alert(data.message || 'Gagal memproses sewa kamera.');
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
                        alert(data.message || 'Gagal memproses pemesanan.');
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
