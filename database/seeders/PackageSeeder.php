<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Paket Standar',
                'subtitle' => 'Kualitas Standar (Budget Friendly)',
                'price_daily' => 400000,
                'base_gear' => 'Sony A6000 (Opsi Upgrade Sony A6400 Rp 600K/day)',
                'crew_fg_count' => 1,
                'crew_vg_count' => 1,
                'has_drone' => false,
                'turnaround_days' => 12,
                'photo_output' => 'Editan foto pilihan terbaik',
                'video_output' => 'Video highlight per day (by phone) + Aftermovie (1–3 menit)',
                'features' => [
                    '1 Photographer (FG) & 1 Videographer (VG)',
                    'Gear Sony A6000 Mirrorless (Tersedia Upgrade A6400)',
                    'Video Highlight Harian via Phone untuk Instagram Reels / TikTok',
                    'Cinematic Aftermovie durasi 1–3 Menit',
                    'Koleksi Foto Terpilih yang Sudah Diedit Warna',
                    'Estimasi Pengerjaan: 12 Hari Kerja',
                    'Pengiriman via Google Drive High Quality',
                ],
                'is_popular' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Paket Menengah',
                'subtitle' => 'Kualitas Baik (Best Value Pilihan Komunitas)',
                'price_daily' => 750000,
                'base_gear' => 'Sony A7II Full Frame + Drone Aerial 4K',
                'crew_fg_count' => 1,
                'crew_vg_count' => 1,
                'has_drone' => true,
                'turnaround_days' => 5,
                'photo_output' => 'Semua Foto Full Edit (Tone & Color Grading)',
                'video_output' => 'Video highlight per day (by phone) + Aftermovie Sinematik (1–5 menit)',
                'features' => [
                    '1 Photographer (FG) & 1 Videographer (VG)',
                    'TERMASUK Pilot Drone & Shoot Udara 4K',
                    'Gear Kamera Full Frame Sony A7II (5-Axis Stabilizer)',
                    'Semua Foto Diedit Penuh (Full Color Grading)',
                    'Video Highlight Cepat Harian by Phone',
                    'Cinematic Aftermovie durasi 1–5 Menit Beresolusi Tinggi',
                    'Estimasi Pengerjaan Cepat: 5 Hari Kerja Selesai',
                    'Seluruh File Mentah (RAW/Original) Diberikan',
                ],
                'is_popular' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Paket Premium',
                'subtitle' => 'Kualitas Tajam & Fast SLA (Pro Event & Corporate)',
                'price_daily' => 850000,
                'base_gear' => 'Sony A7C Full Frame + Drone Aerial 4K',
                'crew_fg_count' => 1,
                'crew_vg_count' => 1,
                'has_drone' => true,
                'turnaround_days' => 4,
                'photo_output' => 'Semua Foto Full Edit dengan Signature Color Palette',
                'video_output' => 'Video reels harian + Aftermovie Sinematik 4K (1–5 menit)',
                'features' => [
                    '1 Photographer (FG) & 1 Videographer (VG)',
                    'TERMASUK Pilot Drone & Shoot Udara 4K',
                    'Gear Sony A7C Full Frame (Sensor BSI & Color Science Mutakhir)',
                    'Semua Foto Full Edit (Skin Tone Halus & Warna Panggung Tajam)',
                    'Video Highlight Harian Fast-Cut untuk Media Sosial',
                    'Master Cinematic Aftermovie 1–5 Menit (Audio & Sound Design Pro)',
                    'PRIORITAS EDITING: 4 Hari Kerja Langsung Selesai',
                    'Cloud Storage Khusus Dezzly Selama 6 Bulan',
                ],
                'is_popular' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Enterprise & Multi-Streaming',
                'subtitle' => 'Complex Event, Multi-Cam & Live Broadcast',
                'price_daily' => 0, // Custom Quote
                'base_gear' => 'Multi-Cam Setup + Video Switcher + Audio Management',
                'crew_fg_count' => 2,
                'crew_vg_count' => 2,
                'has_drone' => true,
                'turnaround_days' => 3,
                'photo_output' => 'Live Photo Sharing & Full Master Edit',
                'video_output' => 'Live Streaming Multi-Platform + Same Day Edit Reel',
                'features' => [
                    'Full Crew: 2 FG + 2 VG + Operator Switcher + Sound Engineer',
                    'Multi-Cam Shooting dari Berbagai Sudut Panggung',
                    'Sistem Video Switcher Siaran Langsung (Live Production)',
                    'Multistreaming Simultan ke Zoom, YouTube, dan Instagram',
                    'Peralatan Audio Khusus (Direct Soundboard Output & Wireless Mic)',
                    'Same-Day-Edit (SDE) Teaser untuk diputar saat Closing Ceremony',
                    'Konsultasi Rundown & Rapat Teknis Lapangan (Technical Meeting)',
                ],
                'is_popular' => false,
                'is_active' => true,
            ],
        ];

        foreach ($packages as $pkg) {
            Package::updateOrCreate(
                ['slug' => Str::slug($pkg['name'])],
                array_merge($pkg, ['slug' => Str::slug($pkg['name'])])
            );
        }
    }
}
