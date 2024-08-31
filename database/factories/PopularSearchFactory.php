<?php

namespace Database\Factories;

use App\Ahkas\Domain\Search\PopularSearchModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PopularSearchFactory extends Factory
{

    protected $model = PopularSearchModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'search_text' => $this->faker->name(),
        ];
    }
}
