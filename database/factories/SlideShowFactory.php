<?php

namespace Database\Factories;

use App\Ahkas\Domain\SlideShow\SlideShowModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SlideShowFactory extends Factory
{
    protected $model = SlideShowModel::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),

            'image' => $this->faker->imageUrl(),
        ];
    }
}
