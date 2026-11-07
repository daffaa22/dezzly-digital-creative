<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminEmail = (string) config('app.admin_email');
        $adminPassword = config('app.admin_password');

        if (empty($adminPassword)) {
            if (app()->environment('production')) {
                throw new \RuntimeException('ADMIN_PASSWORD wajib diisi di environment production sebelum menjalankan seeder.');
            }

            $adminPassword = 'dezzly123';
        }

        // Admin Account for Dezzly Creative
        User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Dezzly Admin',
                'password' => Hash::make($adminPassword),
            ]
        );

        $this->call([
            RentalItemSeeder::class,
            PackageSeeder::class,
            PortfolioItemSeeder::class,
            SiteSettingSeeder::class,
            FaqItemSeeder::class,
        ]);
    }
}
