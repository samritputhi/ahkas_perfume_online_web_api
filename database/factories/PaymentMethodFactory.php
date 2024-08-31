<?php

namespace Database\Factories;

use App\Ahkas\Domain\PaymentMethod\PaymentMethodModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PaymentMethodFactory extends Factory
{

    protected $model = PaymentMethodModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bank' => $this->faker->randomElement(['aba', 'acleda', 'wing']),
            'account_holder' => $this->faker->name(),
            'account_number' => $this->faker->creditCardNumber(),
            'description' => $this->faker->paragraph(1),
        ];
    }
}
