<?php

namespace Database\Seeders;

use App\Models\PortfolioItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PortfolioItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $portfolios = [
            [
                'title' => 'Nusantara Tech Summit 2026',
                'category' => 'Corporate',
                'client_name' => 'Kementerian Komunikasi & Informatika RI',
                'event_date' => '2026-08-15',
                'venue' => 'Jakarta Convention Center (JCC) Senayan',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=1200&q=80',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'gear_used' => 'Sony A7C + Sony A7III + Drone DJI + FE 28-70mm',
                'brief' => 'Mendokumentasikan konferensi teknologi nasional dengan 3 panggung paralel, liputan keynote speaker, dan teaser highlight harian untuk media sosial.',
                'concept_3d' => 'Visual dinamis dengan framing panggung futuristik, pergerakan kamera halus di keramaian peserta, dan color grading bernuansa modern tech blue-teal.',
                'execution_notes' => 'Tim 4 orang berhasil memproduksi video highlight berdurasi 60 detik setiap pukul 18.00 WIB untuk langsung diunggah ke akun resmi.',
                'audience_count' => 3500,
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Aura Soundfest: Open Air Music Celebration',
                'category' => 'Concert & Show',
                'client_name' => 'Soundwave Entertainment',
                'event_date' => '2026-09-20',
                'venue' => 'Stadion Madya GBK, Jakarta',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=1200&q=80',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'gear_used' => 'Sony A7C + Drone DJI Mavic 3 + Sigma 16mm F1.4',
                'brief' => 'Liputan festival musik 12 jam nonstop dengan fokus pada energi penonton, pencahayaan panggung malam hari, dan sweeping drone aerial raksasa.',
                'concept_3d' => 'Sinkronisasi ritme musik (beat-matched editing), footage low-light bersih tanpa noise berkat sensor Full Frame Sony A7C, dan aerial crowd shots.',
                'execution_notes' => 'Menghasilkan Aftermovie Sinematik 3 menit dengan 400.000+ views di YouTube dalam 48 jam pasca acara.',
                'audience_count' => 12000,
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Urban Glow Brand Activation & Pop-Up Studio',
                'category' => 'Brand Activation',
                'client_name' => 'Verve Cosmetics Indonesia',
                'event_date' => '2026-10-05',
                'venue' => 'Main Atrium Grand Indonesia',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1200&q=80',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'gear_used' => 'Sony A7II + Sony FE 50mm F1.8 + Gimbal Ronin',
                'brief' => 'Peluncuran produk perawatan kulit terbaru dengan instalasi booth experiential interaktif, live demo makeup influencer, dan photo booth eksklusif.',
                'concept_3d' => 'Tekankan kelembutan skin-tone para beauty creator dengan bukaan F1.8 Sony FE 50mm, pencahayaan soft neon, dan komposisi simetris mewah.',
                'execution_notes' => '100% foto portrait berhasil ditransfer seketika ke para influencer untuk posting story di tempat.',
                'audience_count' => 1500,
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Annual Corporate Gala & Awarding Night',
                'category' => 'Corporate',
                'client_name' => 'PT Mandiri Prima Logistik',
                'event_date' => '2026-10-25',
                'venue' => 'Grand Ballroom Hotel Mulia Senayan',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=1200&q=80',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'gear_used' => 'Sony A7III + Sony A6400 + Switcher Multi-Cam',
                'brief' => 'Malam penganugerahan karyawan berprestasi dengan live feed ke layar LED panggung utama dan rekaman master multi-angle.',
                'concept_3d' => 'Atmosfer formal berkelas, penangkapan momen emosional pemenang penghargaan, serta dokumentasi jajaran direksi dan tamu VVIP.',
                'execution_notes' => 'Penyerahan teaser 90 detik saat akhir acara (Same-Day-Edit) yang langsung diapresiasi oleh Direktur Utama.',
                'audience_count' => 800,
                'is_featured' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($portfolios as $item) {
            PortfolioItem::updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                array_merge($item, ['slug' => Str::slug($item['title'])])
            );
        }
    }
}
