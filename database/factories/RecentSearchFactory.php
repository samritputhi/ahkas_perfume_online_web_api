<?php

namespace Database\Factories;

use App\Ahkas\Domain\Search\RecentSearchModel;
use App\Ahkas\Domain\User\UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RecentSearchFactory extends Factory
{

    protected $model = RecentSearchModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => UserModel::all()->random(),
            'search_text' => $this->faker->name(),
        ];
    }
}
