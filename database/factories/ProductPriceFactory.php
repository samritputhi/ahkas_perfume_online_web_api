<?php

namespace Database\Factories;

use App\Ahkas\Domain\Brand\BrandModel;
use App\Ahkas\Domain\Category\CategoryModel;
use App\Ahkas\Domain\Product\ProductPriceModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductPriceFactory extends Factory
{
    protected $model = ProductPriceModel::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->colorName(),
            'price' => $this->faker->numberBetween(10, 20),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
