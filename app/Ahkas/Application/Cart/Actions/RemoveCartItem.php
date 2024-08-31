<?php

namespace App\Ahkas\Application\Cart\Actions;

use App\Ahkas\Domain\Cart\CartItemModel;
use App\Ahkas\Domain\Cart\CartModel;
use Illuminate\Support\Facades\DB;
use Throwable;

class RemoveCartItem
{
    /**
     * @throws Throwable
     */
    public function __invoke(CartModel $cart, CartItemModel $cartItem): CartModel|null
    {
        DB::transaction(function () use ($cart, $cartItem) {
            $cartItem->delete();
            $cart->save();
        });

        $cart->refreshCart();

        if ($cart->isEmpty()) {
            $cart->delete();
            return null;
        }

        return $cart->refresh();
    }
}
