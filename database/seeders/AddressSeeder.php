<?php

namespace Database\Seeders;

use App\Ahkas\Domain\Address\AddressModel;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AddressModel::factory(5)->create();
    }
}
