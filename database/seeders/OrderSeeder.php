<?php

namespace Database\Seeders;

use App\Ahkas\Domain\Address\AddressModel;
use App\Ahkas\Domain\Order\OrderModel;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        OrderModel::factory(100)->create();
    }
}
