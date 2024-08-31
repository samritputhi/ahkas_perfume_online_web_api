<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AdminUserSeeder::class,
            SlideShowSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            ProductPriceSeeder::class,
            AddressSeeder::class,
            RecentSearchSeeder::class,
            PopularSearchSeeder::class,
            PaymentMethodSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
        ]);
    }
}
