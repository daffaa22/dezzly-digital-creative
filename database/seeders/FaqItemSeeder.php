<?php

namespace Database\Seeders;

use App\Models\FaqItem;
use Illuminate\Database\Seeder;

class FaqItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Mengapa harga paket dokumentasi tidak dicantumkan angka pasti di website?',
                'answer' => 'Karena setiap acara memiliki skala, durasi waktu, lokasi, serta kebutuhan peralatan yang berbeda-beda. Kami memberikan penawaran fleksibel yang paling hemat dan rasional sesuai anggaran Anda setelah berdiskusi langsung, sehingga Anda tidak membayar hal-hal yang tidak Anda perlukan.',
                'category' => 'Dokumentasi',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'Berapa lama estimasi proses penyerahan file hasil foto & video selesai?',
                'answer' => 'Untuk file foto preview/mentah dapat langsung diunduh 1x24 jam setelah acara. Sedangkan foto yang sudah diedit rapi (color grading) dan video sinematik teaser/highlight selesai dalam rentang waktu 4 hingga 7 hari kerja.',
                'category' => 'Dokumentasi',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah Dezzly Creative melayani liputan dokumentasi ke luar kota?',
                'answer' => 'Bisa! Kami siap melayani acara di seluruh kota di Indonesia (Bandung, Yogyakarta, Surabaya, Bali, dsb). Biaya akomodasi dan transportasi perjalanan darat/udara disesuaikan secara transparan pada penawaran resmi.',
                'category' => 'Layanan',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'question' => 'Apa saja kelengkapan bawaan saat menyewa kamera di Dezzly?',
                'answer' => 'Setiap unit sewa kamera sudah dilengkapi dengan: Bodi kamera Sony, minimal 2 unit baterai original, charger resmi, tali strap kamera empuk, tas pelindung tahan benturan, dan memory card high-speed (opsional/tersedia).',
                'category' => 'Sewa Kamera',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana mekanisme sistem pembayaran, DP, dan pelunasan?',
                'answer' => 'Untuk jasa dokumentasi, penguncian tanggal dilakukan dengan DP 30%–50%, dan pelunasan dapat dilakukan saat acara selesai atau sebelum penyerahan master file. Untuk sewa kamera, pembayaran sewa dilakukan di awal saat serah terima unit di studio.',
                'category' => 'Pembayaran',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah paket dengan rekaman drone sudah termasuk pilot berlisensi?',
                'answer' => 'Ya, betul! Paket dokumentasi kami yang menyertakan drone sudah mencakup unit drone 4K beserta pilot profesional berpengalaman, sehingga Anda tidak perlu memikirkan pengoperasian dan keselamatan penerbangan udara di lokasi.',
                'category' => 'Dokumentasi',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            FaqItem::updateOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
}
