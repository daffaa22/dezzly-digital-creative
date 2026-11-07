@extends('layouts.admin')

@section('title', 'CMS: Pengaturan Info & Teks Landing Page - DEZZLY CREATIVE')

@section('content')
<div class="py-8 sm:py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-6 rounded-2xl bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 shadow-sm">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-sky-500 animate-pulse"></span>
                <span class="text-xs font-extrabold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Content Management System</span>
            </div>
            <h1 class="font-extrabold text-2xl sm:text-3xl text-slate-900 dark:text-white mt-1">
                Pengaturan Teks & Informasi Landing Page
            </h1>
            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                Ubah informasi kontak, nomor WhatsApp, headline hero, syarat sewa, dan keunggulan secara langsung tanpa mengotak-atik kode.
            </p>
        </div>
    </div>

    {{-- Feedback Flash Message --}}
    @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border-2 border-emerald-300 dark:border-emerald-700 text-emerald-900 dark:text-emerald-300 text-sm font-bold flex items-center justify-between">
        <span>✓ {{ session('success') }}</span>
    </div>
    @endif

    <form action="{{ route('admin.cms.settings.update') }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        {{-- 1. Identitas Studio & Kontak WhatsApp --}}
        <div class="bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
            <div class="border-b-2 border-slate-100 dark:border-slate-700 pb-4">
                <h3 class="font-extrabold text-lg text-slate-900 dark:text-white flex items-center gap-2">
                    <span>🏢</span>
                    <span>Identitas Studio, Kontak & Strip Pengumuman</span>
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    Informasi ini akan muncul di strip atas, navbar, tombol WhatsApp, dan footer website.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nama Studio / Brand:</label>
                    <input type="text" name="studio_name" value="{{ \App\Models\SiteSetting::get('studio_name', 'DEZZLY CREATIVE') }}"
                           class="w-full bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white font-bold focus:border-[#0284C7] focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nomor WhatsApp Resmi:</label>
                    <input type="text" name="whatsapp_number" value="{{ \App\Models\SiteSetting::get('whatsapp_number', '0821-4603-1398') }}"
                           placeholder="0821-4603-1398"
                           class="w-full bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white font-mono font-bold focus:border-[#0284C7] focus:outline-none">
                    <span class="text-[11px] text-slate-500 mt-1 block">Semua tombol pemesanan dan floating CTA akan mengarah ke nomor ini.</span>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Area Wilayah Layanan:</label>
                    <input type="text" name="operational_area" value="{{ \App\Models\SiteSetting::get('operational_area', 'Jabodetabek dan sekitarnya (Siap melayani perjalanan luar kota)') }}"
                           class="w-full bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white font-medium focus:border-[#0284C7] focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Status Strip Atas:</label>
                    <input type="text" name="top_strip_status" value="{{ \App\Models\SiteSetting::get('top_strip_status', 'Studio Aktif & Siap Melayani') }}"
                           class="w-full bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white font-medium focus:border-[#0284C7] focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Slogan Strip Atas:</label>
                    <input type="text" name="top_strip_text" value="{{ \App\Models\SiteSetting::get('top_strip_text', 'Dokumentasi Event & Sewa Kamera Terpercaya') }}"
                           class="w-full bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white font-medium focus:border-[#0284C7] focus:outline-none">
                </div>
            </div>
        </div>

        {{-- 2. Hero Section (Headline & Deskripsi Utama) --}}
        <div class="bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
            <div class="border-b-2 border-slate-100 dark:border-slate-700 pb-4">
                <h3 class="font-extrabold text-lg text-slate-900 dark:text-white flex items-center gap-2">
                    <span>✨</span>
                    <span>Teks Hero (Bagian Utama Atas)</span>
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    Kalimat pembuka yang pertama kali dilihat oleh calon klien saat membuka website.
                </p>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Badge Di Atas Judul:</label>
                    <input type="text" name="hero_badge" value="{{ \App\Models\SiteSetting::get('hero_badge', 'Vendor Resmi Dokumentasi Event & Persewaan Kamera') }}"
                           class="w-full bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white font-semibold focus:border-[#0284C7] focus:outline-none">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Headline Baris 1 (Hitam):</label>
                        <input type="text" name="hero_headline_1" value="{{ \App\Models\SiteSetting::get('hero_headline_1', 'Abadikan Setiap Momen Berharga.') }}"
                               class="w-full bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white font-extrabold focus:border-[#0284C7] focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Headline Baris 2 (Biru Penekanan):</label>
                        <input type="text" name="hero_headline_2" value="{{ \App\Models\SiteSetting::get('hero_headline_2', 'Hasil Tajam, Pelayanan Ramah & Terpercaya.') }}"
                               class="w-full bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2.5 text-sm text-[#0284C7] dark:text-sky-400 font-extrabold focus:border-[#0284C7] focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Paragraf Penjelasan / Subteks Hero:</label>
                    <textarea name="hero_subtext" rows="3"
                              class="w-full bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-600 rounded-xl p-4 text-sm text-slate-900 dark:text-white font-medium focus:border-[#0284C7] focus:outline-none leading-relaxed">{{ \App\Models\SiteSetting::get('hero_subtext', 'Kami melayani kebutuhan dokumentasi foto, rekaman video beresolusi tinggi, pilot drone 4K, hingga persewaan kamera Sony Alpha untuk acara keluarga, pernikahan, gathering kantor, maupun konser resmi.') }}</textarea>
                </div>
            </div>
        </div>

        {{-- 3. Statistik / Metrik Hero --}}
        <div class="bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
            <div class="border-b-2 border-slate-100 dark:border-slate-700 pb-4">
                <h3 class="font-extrabold text-lg text-slate-900 dark:text-white flex items-center gap-2">
                    <span>📈</span>
                    <span>4 Kartu Statistik / Metrik Hero</span>
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    Angka bukti kredibilitas yang tampil di bawah tombol CTA Hero.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                {{-- Metric 1 --}}
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/50 border-2 border-slate-200 dark:border-slate-700 space-y-3">
                    <span class="text-xs font-extrabold text-[#0284C7] dark:text-sky-400 block uppercase">Kartu 1</span>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase">Nilai/Angka:</label>
                        <input type="text" name="metric_1_value" value="{{ \App\Models\SiteSetting::get('metric_1_value', '250+') }}" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-1.5 text-sm font-bold text-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase">Judul:</label>
                        <input type="text" name="metric_1_title" value="{{ \App\Models\SiteSetting::get('metric_1_title', 'Acara Sukses') }}" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-1.5 text-xs font-semibold text-slate-800 dark:text-slate-200">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase">Keterangan:</label>
                        <input type="text" name="metric_1_subtitle" value="{{ \App\Models\SiteSetting::get('metric_1_subtitle', 'Terdokumentasi rapi') }}" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-1.5 text-xs text-slate-600 dark:text-slate-400">
                    </div>
                </div>

                {{-- Metric 2 --}}
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/50 border-2 border-slate-200 dark:border-slate-700 space-y-3">
                    <span class="text-xs font-extrabold text-emerald-600 dark:text-emerald-400 block uppercase">Kartu 2</span>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase">Nilai/Angka:</label>
                        <input type="text" name="metric_2_value" value="{{ \App\Models\SiteSetting::get('metric_2_value', 'Drone') }}" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-1.5 text-sm font-bold text-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase">Judul:</label>
                        <input type="text" name="metric_2_title" value="{{ \App\Models\SiteSetting::get('metric_2_title', 'Rekaman Udara 4K') }}" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-1.5 text-xs font-semibold text-slate-800 dark:text-slate-200">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase">Keterangan:</label>
                        <input type="text" name="metric_2_subtitle" value="{{ \App\Models\SiteSetting::get('metric_2_subtitle', 'Paket lengkap pilihan') }}" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-1.5 text-xs text-slate-600 dark:text-slate-400">
                    </div>
                </div>

                {{-- Metric 3 --}}
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/50 border-2 border-slate-200 dark:border-slate-700 space-y-3">
                    <span class="text-xs font-extrabold text-purple-600 dark:text-purple-400 block uppercase">Kartu 3</span>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase">Nilai/Angka:</label>
                        <input type="text" name="metric_3_value" value="{{ \App\Models\SiteSetting::get('metric_3_value', '4-5 Hari') }}" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-1.5 text-sm font-bold text-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase">Judul:</label>
                        <input type="text" name="metric_3_title" value="{{ \App\Models\SiteSetting::get('metric_3_title', 'Hasil Cepat Selesai') }}" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-1.5 text-xs font-semibold text-slate-800 dark:text-slate-200">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase">Keterangan:</label>
                        <input type="text" name="metric_3_subtitle" value="{{ \App\Models\SiteSetting::get('metric_3_subtitle', 'Garansi waktu pengerjaan') }}" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-1.5 text-xs text-slate-600 dark:text-slate-400">
                    </div>
                </div>

                {{-- Metric 4 --}}
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/50 border-2 border-slate-200 dark:border-slate-700 space-y-3">
                    <span class="text-xs font-extrabold text-amber-600 dark:text-amber-400 block uppercase">Kartu 4</span>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase">Nilai/Angka:</label>
                        <input type="text" name="metric_4_value" value="{{ \App\Models\SiteSetting::get('metric_4_value', 'Sony') }}" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-1.5 text-sm font-bold text-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase">Judul:</label>
                        <input type="text" name="metric_4_title" value="{{ \App\Models\SiteSetting::get('metric_4_title', 'Full Frame Alpha') }}" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-1.5 text-xs font-semibold text-slate-800 dark:text-slate-200">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase">Keterangan:</label>
                        <input type="text" name="metric_4_subtitle" value="{{ \App\Models\SiteSetting::get('metric_4_subtitle', 'Sensor jernih & tajam') }}" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-1.5 text-xs text-slate-600 dark:text-slate-400">
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. Syarat & Prosedur Sewa Kamera --}}
        <div class="bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
            <div class="border-b-2 border-slate-100 dark:border-slate-700 pb-4">
                <h3 class="font-extrabold text-lg text-slate-900 dark:text-white flex items-center gap-2">
                    <span>📋</span>
                    <span>Syarat & Prosedur Sewa Kamera</span>
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    Aturan transparansi sewa kamera 24 jam agar penyewa merasa aman dan jelas.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <h4 class="text-sm font-extrabold text-[#0284C7] dark:text-sky-400 uppercase tracking-wide">3 Syarat Utama Sewa</h4>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Syarat 1 (Identitas):</label>
                        <textarea name="terms_id_card" rows="2" class="w-full bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-600 rounded-xl p-3 text-xs text-slate-800 dark:text-slate-200">{{ \App\Models\SiteSetting::get('terms_id_card', 'Wajib menyertakan minimal 2 Identitas Asli (KTP / SIM / Paspor / NPWP / Kartu Pegawai) yang masih berlaku.') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Syarat 2 (Deposit):</label>
                        <textarea name="terms_deposit" rows="2" class="w-full bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-600 rounded-xl p-3 text-xs text-slate-800 dark:text-slate-200">{{ \App\Models\SiteSetting::get('terms_deposit', 'Deposit jaminan / uang titipan (bila diperlukan) yang akan dikembalikan 100% setelah unit dicek utuh.') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Syarat 3 (Tanggung Jawab):</label>
                        <textarea name="terms_responsible" rows="2" class="w-full bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-600 rounded-xl p-3 text-xs text-slate-800 dark:text-slate-200">{{ \App\Models\SiteSetting::get('terms_responsible', 'Penyewa bertanggung jawab penuh atas kebersihan dan keutuhan bodi kamera & lensa selama masa sewa.') }}</textarea>
                    </div>
                </div>

                <div class="space-y-4">
                    <h4 class="text-sm font-extrabold text-emerald-600 dark:text-emerald-400 uppercase tracking-wide">3 Alur Prosedur Pengambilan</h4>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Langkah 1 (Booking):</label>
                        <textarea name="procedure_1" rows="2" class="w-full bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-600 rounded-xl p-3 text-xs text-slate-800 dark:text-slate-200">{{ \App\Models\SiteSetting::get('procedure_1', 'Pilih unit kamera di kalkulator web atau hubungi admin WhatsApp untuk konfirmasi tanggal sewa.') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Langkah 2 (Serah Terima):</label>
                        <textarea name="procedure_2" rows="2" class="w-full bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-600 rounded-xl p-3 text-xs text-slate-800 dark:text-slate-200">{{ \App\Models\SiteSetting::get('procedure_2', 'Serah terima unit dan cek kondisi fisik bersama staf Dezzly di studio operasional.') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Langkah 3 (Pengembalian):</label>
                        <textarea name="procedure_3" rows="2" class="w-full bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-600 rounded-xl p-3 text-xs text-slate-800 dark:text-slate-200">{{ \App\Models\SiteSetting::get('procedure_3', 'Kembalikan unit tepat waktu 24 jam kemudian, deposit dan identitas dikembalikan seketika.') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- 5. Keunggulan Dezzly Creative (Benchmark) --}}
        <div class="bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
            <div class="border-b-2 border-slate-100 dark:border-slate-700 pb-4">
                <h3 class="font-extrabold text-lg text-slate-900 dark:text-white flex items-center gap-2">
                    <span>🏆</span>
                    <span>4 Keunggulan Utama (Benchmark Layanan)</span>
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    Alasan mengapa klien memilih Dezzly Creative dibandingkan vendor biasa.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Keunggulan 1 --}}
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/50 border-2 border-slate-200 dark:border-slate-700 space-y-2">
                    <label class="block text-xs font-bold text-[#0284C7] dark:text-sky-400 uppercase">Keunggulan 1 - Judul:</label>
                    <input type="text" name="benchmark_1_title" value="{{ \App\Models\SiteSetting::get('benchmark_1_title', 'Sensor Full Frame Sony Alpha Asli') }}" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-2 text-sm font-bold text-slate-900 dark:text-white">
                    <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mt-2">Deskripsi:</label>
                    <textarea name="benchmark_1_desc" rows="2" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg p-2.5 text-xs text-slate-700 dark:text-slate-300">{{ \App\Models\SiteSetting::get('benchmark_1_desc', 'Kamera standar industri sinema & fotografi profesional dengan ketajaman warna luar biasa.') }}</textarea>
                </div>

                {{-- Keunggulan 2 --}}
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/50 border-2 border-slate-200 dark:border-slate-700 space-y-2">
                    <label class="block text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase">Keunggulan 2 - Judul:</label>
                    <input type="text" name="benchmark_2_title" value="{{ \App\Models\SiteSetting::get('benchmark_2_title', 'Pilot Drone Berlisensi & Berpengalaman') }}" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-2 text-sm font-bold text-slate-900 dark:text-white">
                    <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mt-2">Deskripsi:</label>
                    <textarea name="benchmark_2_desc" rows="2" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg p-2.5 text-xs text-slate-700 dark:text-slate-300">{{ \App\Models\SiteSetting::get('benchmark_2_desc', 'Penerbangan udara aman, stabil, bersertifikat, dan menghasilkan rekaman 4K ultra jernih.') }}</textarea>
                </div>

                {{-- Keunggulan 3 --}}
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/50 border-2 border-slate-200 dark:border-slate-700 space-y-2">
                    <label class="block text-xs font-bold text-purple-600 dark:text-purple-400 uppercase">Keunggulan 3 - Judul:</label>
                    <input type="text" name="benchmark_3_title" value="{{ \App\Models\SiteSetting::get('benchmark_3_title', 'Garansi Waktu Penyerahan File 4-5 Hari') }}" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-2 text-sm font-bold text-slate-900 dark:text-white">
                    <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mt-2">Deskripsi:</label>
                    <textarea name="benchmark_3_desc" rows="2" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg p-2.5 text-xs text-slate-700 dark:text-slate-300">{{ \App\Models\SiteSetting::get('benchmark_3_desc', 'Proses editing cepat dan tepat waktu tanpa mengurangi estetika grading warna.') }}</textarea>
                </div>

                {{-- Keunggulan 4 --}}
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/50 border-2 border-slate-200 dark:border-slate-700 space-y-2">
                    <label class="block text-xs font-bold text-amber-600 dark:text-amber-400 uppercase">Keunggulan 4 - Judul:</label>
                    <input type="text" name="benchmark_4_title" value="{{ \App\Models\SiteSetting::get('benchmark_4_title', 'Unit Bersih & Terkalibrasi Sebelum Disewa') }}" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-2 text-sm font-bold text-slate-900 dark:text-white">
                    <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mt-2">Deskripsi:</label>
                    <textarea name="benchmark_4_desc" rows="2" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg p-2.5 text-xs text-slate-700 dark:text-slate-300">{{ \App\Models\SiteSetting::get('benchmark_4_desc', 'Setiap kamera dan lensa diservis, disensor-clean, dan dicek optiknya sebelum diberikan ke penyewa.') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Sticky Save Action Bar --}}
        <div class="sticky bottom-6 z-30 p-4 rounded-2xl bg-slate-900/90 dark:bg-slate-800/95 backdrop-blur-md border-2 border-sky-400/50 shadow-2xl flex items-center justify-between gap-4">
            <div class="text-white text-xs sm:text-sm font-semibold flex items-center gap-2">
                <span class="text-emerald-400">●</span>
                <span>Pastikan perubahan telah sesuai sebelum menyimpan.</span>
            </div>
            <button type="submit"
                    class="px-6 sm:px-8 py-3 rounded-xl bg-[#0284C7] hover:bg-[#0369A1] text-white font-extrabold text-sm shadow-lg shadow-sky-600/30 transition-all hover:scale-105 active:scale-95 cursor-pointer">
                💾 Simpan Semua Perubahan Teks
            </button>
        </div>

    </form>

</div>
@endsection

