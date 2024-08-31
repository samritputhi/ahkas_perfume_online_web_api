<?php

namespace Database\Seeders;

use App\Ahkas\Domain\Address\AddressModel;
use App\Ahkas\Domain\Order\OrderItemModel;
use App\Ahkas\Domain\Order\OrderModel;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (OrderModel::all() as $order) {
            OrderItemModel::factory(5)->create([
                'order_id' => $order->id,
            ]);
        }
    }
}
