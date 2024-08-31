<?php

namespace Database\Factories;

use App\Ahkas\Domain\Order\OrderItemModel;
use App\Ahkas\Domain\Product\ProductModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrderItemFactory extends Factory
{
    protected $model = OrderItemModel::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => ProductModel::all()->random(),
            'price_per_item' => $this->faker->numberBetween(10, 20),
            'price_per_item_after_discount' => $this->faker->numberBetween(10, 20),
            'total_item_price' => $this->faker->numberBetween(10, 20),
            'total_item_price_after_discount' => $this->faker->numberBetween(10, 20),
            'qty' => $this->faker->numberBetween(1, 5),
            'discount_percent' => 0,
        ];
    }
}
