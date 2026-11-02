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
        // Admin Account for Dezzly Creative
        User::firstOrCreate(
            ['email' => 'admin@dezzlycreative.com'],
            [
                'name' => 'Dezzly Admin',
                'password' => Hash::make('dezzly123'),
            ]
        );

        $this->call([
            RentalItemSeeder::class,
            PackageSeeder::class,
            PortfolioItemSeeder::class,
        ]);
    }
}
