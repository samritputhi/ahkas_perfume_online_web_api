<?php

namespace Database\Seeders;

use App\Ahkas\Domain\PaymentMethod\PaymentMethodModel;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMethodModel::factory(5)->create();
    }
}
