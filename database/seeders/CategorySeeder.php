<?php

namespace Database\Seeders;

use App\Ahkas\Domain\Category\CategoryModel;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoryModel::factory(5)->create();
    }
}
