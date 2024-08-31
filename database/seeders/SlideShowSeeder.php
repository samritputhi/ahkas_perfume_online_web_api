<?php

namespace Database\Seeders;

use App\Ahkas\Domain\SlideShow\SlideShowModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SlideShowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SlideShowModel::factory(5)->create();
    }
}
