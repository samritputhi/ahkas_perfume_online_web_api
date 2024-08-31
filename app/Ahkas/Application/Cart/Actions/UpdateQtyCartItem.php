<?php

namespace App\Ahkas\Application\Cart\Actions;

use App\Ahkas\Domain\Cart\CartItemModel;
use App\Ahkas\Domain\Cart\CartModel;

class UpdateQtyCartItem
{
    public function __invoke(CartModel $cart, CartItemModel $cartItem, int $qty): CartModel|null
    {

        if ($qty === 0) {
            $cartItem->delete();
            if ($cart->fresh()->isEmpty()) {
                $cart->delete();
                return null;
            }
            $cart->save();
            return $cart;
        }

        $cartItem->qty = $qty;

        $cartItem->total_item_price = $qty * $cartItem->price_per_item;
        $cartItem->total_item_price_after_discount = $qty * $cartItem->price_per_item_after_discount;
        $cartItem->save();

        $cart->refreshCart()->save();

        return $cart;
    }
}
