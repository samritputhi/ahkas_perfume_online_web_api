<?php

namespace Database\Seeders;

use App\Ahkas\Domain\Search\RecentSearchModel;
use Illuminate\Database\Seeder;

class RecentSearchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RecentSearchModel::factory(10)->create();
    }
}
