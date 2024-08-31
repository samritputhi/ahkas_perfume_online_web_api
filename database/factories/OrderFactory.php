<?php

namespace Database\Factories;

use App\Ahkas\Domain\Order\enum\OrderStatusEnum;
use App\Ahkas\Domain\Order\OrderModel;
use App\Ahkas\Domain\User\UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrderFactory extends Factory
{
    protected $model = OrderModel::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_number' => $this->faker->swiftBicNumber(),
            'user_id' => UserModel::all()->random(),
            'total_item_price' => $this->faker->numberBetween(100, 200),
            'total_item_price_after_discount' => $this->faker->numberBetween(100, 200),
            'total_shipping_cost' => 1.5,
            'status' => $this->faker->randomElement([
                OrderStatusEnum::PENDING,
                OrderStatusEnum::CONFIRM,
                OrderStatusEnum::DELIVERY,
                OrderStatusEnum::RECEIVE,
                OrderStatusEnum::CANCEL,
                OrderStatusEnum::REJECT,
            ]),
        ];
    }
}
