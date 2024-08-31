<?php

namespace Database\Seeders;

use App\Ahkas\Domain\Search\PopularSearchModel;
use App\Ahkas\Domain\Search\RecentSearchModel;
use Illuminate\Database\Seeder;

class PopularSearchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PopularSearchModel::factory(10)->create();
    }
}
