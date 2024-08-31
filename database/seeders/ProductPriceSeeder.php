<?php

namespace Database\Seeders;

use App\Ahkas\Domain\Product\ProductModel;
use App\Ahkas\Domain\Product\ProductPriceModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (ProductModel::all() as $product) {
            ProductPriceModel::factory(2)->create([
                'product_id' => $product->id,
            ]);
        }
    }
}
