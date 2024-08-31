<?php

namespace Database\Seeders;

use App\Ahkas\Domain\Brand\BrandModel;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BrandModel::factory(5)->create();
    }
}
