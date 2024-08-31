<?php

namespace Database\Factories;

use App\Ahkas\Domain\Brand\BrandModel;
use App\Ahkas\Domain\Category\CategoryModel;
use App\Ahkas\Domain\Product\ProductModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    protected $model = ProductModel::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand_id' => BrandModel::all()->random(),
            'category_id' => CategoryModel::all()->random(),
            'name' => $this->faker->name(),
            'description' => $this->faker->paragraph(1),
            'price' => $this->faker->numberBetween(10, 20),
            'image' => [$this->faker->imageUrl(), $this->faker->imageUrl()],
        ];
    }
}
