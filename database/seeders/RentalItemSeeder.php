<?php

namespace Database\Seeders;

use App\Models\RentalItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RentalItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            // Cameras
            [
                'name' => 'Sony A6000',
                'category' => 'camera',
                'sensor_type' => 'APS-C',
                'mount_type' => 'E-Mount',
                'daily_price' => 100000,
                'requires_fe_lens' => false,
                'description' => 'Kamera mirrorless ringkas 24.3 MP dengan autofokus cepat. Ideal untuk dokumentasi pemula, konten media sosial, dan vlogging.',
                'specifications' => [
                    'sensor' => '24.3MP APS-C Exmor APS HD CMOS',
                    'video' => 'Full HD 1080p pada 60 fps',
                    'af_points' => '179 Phase-Detection AF Points',
                    'iso' => '100-25600',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'Sony A6400',
                'category' => 'camera',
                'sensor_type' => 'APS-C',
                'mount_type' => 'E-Mount',
                'daily_price' => 160000,
                'requires_fe_lens' => false,
                'description' => 'Real-time Eye AF tercepat 0.02s dengan perekaman 4K HDR tanpa batasan rekam 30 menit. Pilihan terbaik untuk event dan liputan dinamis.',
                'specifications' => [
                    'sensor' => '24.2MP APS-C Exmor CMOS',
                    'video' => '4K 30fps UHD / FHD 120fps Slow-mo',
                    'af_points' => '425 Phase & Contrast Detection',
                    'screen' => '180° Flip Touchscreen',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'Sony A7R',
                'category' => 'camera',
                'sensor_type' => 'Full Frame',
                'mount_type' => 'FE-Mount',
                'daily_price' => 180000,
                'requires_fe_lens' => true,
                'description' => 'Kamera Full Frame resolusi tinggi 36.4 MP tanpa Optical Low-Pass Filter untuk detail komersial dan foto studio super tajam.',
                'specifications' => [
                    'sensor' => '36.4MP Full-Frame Exmor CMOS',
                    'video' => 'Full HD 1080/60p',
                    'viewfinder' => 'OLED Tru-Finder EVF',
                    'weight' => '407 gram (Lightweight FF)',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1516724562728-afc824a36e84?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'Sony A7II',
                'category' => 'camera',
                'sensor_type' => 'Full Frame',
                'mount_type' => 'FE-Mount',
                'daily_price' => 190000,
                'requires_fe_lens' => true,
                'description' => 'Sensor Full Frame 24.3 MP dengan 5-Axis In-Body Image Stabilization (IBIS). Sangat stabil untuk dokumentasi hand-held hari-H.',
                'specifications' => [
                    'sensor' => '24.3MP Full-Frame Exmor CMOS',
                    'stabilizer' => '5-Axis SteadyShot INSIDE IBIS',
                    'profile' => 'S-Log2 Gamma Profile',
                    'video' => 'Full HD XAVC S 50Mbps',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'Sony A7III',
                'category' => 'camera',
                'sensor_type' => 'Full Frame',
                'mount_type' => 'FE-Mount',
                'daily_price' => 290000,
                'requires_fe_lens' => true,
                'description' => 'Workhorse industri dokumentasi dunia. Dual SD slot, baterai besar NP-FZ100, 4K HDR, dan dynamic range luar biasa 15-stop.',
                'specifications' => [
                    'sensor' => '24.2MP BSI Full-Frame Exmor R',
                    'battery' => 'NP-FZ100 (Tahan Seharian)',
                    'storage' => 'Dual Card Slots (UHS-II)',
                    'video' => '4K 24/30p HDR HLG S-Log3',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1512790182412-b19e6d62bc39?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'Sony A7C',
                'category' => 'camera',
                'sensor_type' => 'Full Frame',
                'mount_type' => 'FE-Mount',
                'daily_price' => 290000,
                'requires_fe_lens' => true,
                'description' => 'Bodi Full Frame paling ringkas dengan warna modern (Color Science mutakhir), LCD vari-angle lipat samping, dan Real-time tracking AF cerdas.',
                'specifications' => [
                    'sensor' => '24.2MP BSI Full-Frame Exmor R',
                    'color_science' => 'Modern Sony Color Science (Skin Tone Halus)',
                    'screen' => 'Vari-angle Side-Flip LCD',
                    'tracking' => 'AI Real-Time AF Tracking',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1581591524425-c7e0978865fc?auto=format&fit=crop&w=800&q=80',
            ],

            // Lenses
            [
                'name' => 'Sigma 16mm F1.4 DC DN Contemporary',
                'category' => 'lens',
                'sensor_type' => 'APS-C',
                'mount_type' => 'E-Mount',
                'daily_price' => 50000,
                'requires_fe_lens' => false,
                'description' => 'Lensa sudut lebar prima bukaan super besar F1.4 untuk kamera APS-C (A6000, A6400). Bokeh creamy dan tajam di ruangan minim cahaya.',
                'specifications' => [
                    'focal_length' => '16mm (Equivalent 24mm FF)',
                    'aperture' => 'F1.4 - F16',
                    'compatibility' => 'Sony E-Mount (APS-C)',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1617005082133-548c4dd27f35?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'Sony FE 50mm F1.8',
                'category' => 'lens',
                'sensor_type' => 'Full Frame',
                'mount_type' => 'FE-Mount',
                'daily_price' => 45000,
                'requires_fe_lens' => false,
                'description' => 'Lensa portrait Full Frame standar (Nifty Fifty). Sangat tajam untuk portrait subjek, MC, narasumber, dan detail ekspresi tamu.',
                'specifications' => [
                    'focal_length' => '50mm Standard Prime',
                    'aperture' => 'F1.8 - F22',
                    'compatibility' => 'Sony FE-Mount (Full Frame & APS-C)',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1589872307379-0ffdf9829123?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'Sony FE 28-70mm F3.5-5.6 OSS',
                'category' => 'lens',
                'sensor_type' => 'Full Frame',
                'mount_type' => 'FE-Mount',
                'daily_price' => 50000,
                'requires_fe_lens' => false,
                'description' => 'Lensa zoom fleksibel Full Frame dilengkapi Optical SteadyShot (OSS). Sangat serbaguna untuk kebutuhan panggung dan liputan dinamis.',
                'specifications' => [
                    'focal_length' => '28-70mm Zoom Serbaguna',
                    'aperture' => 'F3.5 - F5.6',
                    'oss' => 'Optical SteadyShot Image Stabilization',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1563861826100-9cb868fdbe1c?auto=format&fit=crop&w=800&q=80',
            ],
        ];

        foreach ($items as $item) {
            RentalItem::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                array_merge($item, ['slug' => Str::slug($item['name'])])
            );
        }
    }
}
