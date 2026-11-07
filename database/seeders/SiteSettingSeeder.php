<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Identitas Studio & Kontak
            ['key' => 'studio_name', 'value' => 'DEZZLY CREATIVE', 'group' => 'general', 'label' => 'Nama Studio'],
            ['key' => 'studio_tagline', 'value' => 'CREATIVE STUDIO', 'group' => 'general', 'label' => 'Tagline Brand'],
            ['key' => 'whatsapp_number', 'value' => '0821-4603-1398', 'group' => 'general', 'label' => 'Nomor WhatsApp Resmi'],
            ['key' => 'operational_area', 'value' => 'Jabodetabek dan sekitarnya (Siap melayani perjalanan luar kota)', 'group' => 'general', 'label' => 'Area Wilayah Layanan'],
            ['key' => 'top_strip_status', 'value' => 'Studio Aktif & Siap Melayani', 'group' => 'general', 'label' => 'Status Strip Atas'],
            ['key' => 'top_strip_text', 'value' => 'Dokumentasi Event & Sewa Kamera Terpercaya', 'group' => 'general', 'label' => 'Teks Slogan Strip Atas'],

            // Hero Section
            ['key' => 'hero_badge', 'value' => 'Vendor Resmi Dokumentasi Event & Persewaan Kamera', 'group' => 'hero', 'label' => 'Badge Atas Hero'],
            ['key' => 'hero_headline_1', 'value' => 'Abadikan Setiap Momen Berharga.', 'group' => 'hero', 'label' => 'Headline Baris 1'],
            ['key' => 'hero_headline_2', 'value' => 'Hasil Tajam, Pelayanan Ramah & Terpercaya.', 'group' => 'hero', 'label' => 'Headline Baris 2 (Warna Biru)'],
            ['key' => 'hero_subtext', 'value' => 'Kami melayani kebutuhan dokumentasi foto, rekaman video beresolusi tinggi, pilot drone 4K, hingga persewaan kamera Sony Alpha untuk acara keluarga, pernikahan, gathering kantor, maupun konser resmi.', 'group' => 'hero', 'label' => 'Deskripsi / Paragraf Hero'],

            // Metrik / Statistik Hero
            ['key' => 'metric_1_value', 'value' => '250+', 'group' => 'metrics', 'label' => 'Angka Statistik 1'],
            ['key' => 'metric_1_title', 'value' => 'Acara Sukses', 'group' => 'metrics', 'label' => 'Judul Statistik 1'],
            ['key' => 'metric_1_subtitle', 'value' => 'Terdokumentasi rapi', 'group' => 'metrics', 'label' => 'Keterangan Statistik 1'],

            ['key' => 'metric_2_value', 'value' => 'Drone', 'group' => 'metrics', 'label' => 'Angka Statistik 2'],
            ['key' => 'metric_2_title', 'value' => 'Rekaman Udara 4K', 'group' => 'metrics', 'label' => 'Judul Statistik 2'],
            ['key' => 'metric_2_subtitle', 'value' => 'Paket lengkap pilihan', 'group' => 'metrics', 'label' => 'Keterangan Statistik 2'],

            ['key' => 'metric_3_value', 'value' => '4-5 Hari', 'group' => 'metrics', 'label' => 'Angka Statistik 3'],
            ['key' => 'metric_3_title', 'value' => 'Hasil Cepat Selesai', 'group' => 'metrics', 'label' => 'Judul Statistik 3'],
            ['key' => 'metric_3_subtitle', 'value' => 'Garansi waktu pengerjaan', 'group' => 'metrics', 'label' => 'Keterangan Statistik 3'],

            ['key' => 'metric_4_value', 'value' => 'Sony', 'group' => 'metrics', 'label' => 'Angka Statistik 4'],
            ['key' => 'metric_4_title', 'value' => 'Full Frame Alpha', 'group' => 'metrics', 'label' => 'Judul Statistik 4'],
            ['key' => 'metric_4_subtitle', 'value' => 'Sensor jernih & tajam', 'group' => 'metrics', 'label' => 'Keterangan Statistik 4'],

            // Syarat & Prosedur Sewa
            ['key' => 'terms_id_card', 'value' => 'Wajib menyertakan minimal 2 Identitas Asli (KTP / SIM / Paspor / NPWP / Kartu Pegawai) yang masih berlaku.', 'group' => 'terms', 'label' => 'Syarat 1: Identitas'],
            ['key' => 'terms_deposit', 'value' => 'Deposit jaminan / uang titipan (bila diperlukan) yang akan dikembalikan 100% setelah unit dicek utuh.', 'group' => 'terms', 'label' => 'Syarat 2: Deposit Jaminan'],
            ['key' => 'terms_responsible', 'value' => 'Penyewa bertanggung jawab penuh atas kebersihan dan keutuhan bodi kamera & lensa selama masa sewa.', 'group' => 'terms', 'label' => 'Syarat 3: Tanggung Jawab'],
            ['key' => 'procedure_1', 'value' => 'Pilih unit kamera di kalkulator web atau hubungi admin WhatsApp untuk konfirmasi tanggal sewa.', 'group' => 'terms', 'label' => 'Prosedur 1: Booking'],
            ['key' => 'procedure_2', 'value' => 'Serah terima unit dan cek kondisi fisik bersama staf Dezzly di studio operasional.', 'group' => 'terms', 'label' => 'Prosedur 2: Cek Fisik'],
            ['key' => 'procedure_3', 'value' => 'Kembalikan unit tepat waktu 24 jam kemudian, deposit dan identitas dikembalikan seketika.', 'group' => 'terms', 'label' => 'Prosedur 3: Pengembalian'],

            // Keunggulan (Benchmark)
            ['key' => 'benchmark_1_title', 'value' => 'Sensor Full Frame Sony Alpha Asli', 'group' => 'features', 'label' => 'Keunggulan 1: Judul'],
            ['key' => 'benchmark_1_desc', 'value' => 'Kamera standar industri sinema & fotografi profesional dengan ketajaman warna luar biasa.', 'group' => 'features', 'label' => 'Keunggulan 1: Deskripsi'],

            ['key' => 'benchmark_2_title', 'value' => 'Pilot Drone Berlisensi & Berpengalaman', 'group' => 'features', 'label' => 'Keunggulan 2: Judul'],
            ['key' => 'benchmark_2_desc', 'value' => 'Penerbangan udara aman, stabil, bersertifikat, dan menghasilkan rekaman 4K ultra jernih.', 'group' => 'features', 'label' => 'Keunggulan 2: Deskripsi'],

            ['key' => 'benchmark_3_title', 'value' => 'Garansi Waktu Penyerahan File 4-5 Hari', 'group' => 'features', 'label' => 'Keunggulan 3: Judul'],
            ['key' => 'benchmark_3_desc', 'value' => 'Proses editing cepat dan tepat waktu tanpa mengurangi estetika grading warna.', 'group' => 'features', 'label' => 'Keunggulan 3: Deskripsi'],

            ['key' => 'benchmark_4_title', 'value' => 'Unit Bersih & Terkalibrasi Sebelum Disewa', 'group' => 'features', 'label' => 'Keunggulan 4: Judul'],
            ['key' => 'benchmark_4_desc', 'value' => 'Setiap kamera dan lensa diservis, disensor-clean, dan dicek optiknya sebelum diberikan ke penyewa.', 'group' => 'features', 'label' => 'Keunggulan 4: Deskripsi'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        SiteSetting::clearCache();
    }
}
