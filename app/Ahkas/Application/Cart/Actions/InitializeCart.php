<?php

namespace App\Ahkas\Application\Cart\Actions;

use App\Ahkas\Domain\Cart\CartModel;

class InitializeCart
{
    public function __invoke(int $userId): CartModel
    {
        return CartModel::create([
            'user_id' => $userId,
            'total_shipping_cost' => 1.5,
        ]);
    }
}
