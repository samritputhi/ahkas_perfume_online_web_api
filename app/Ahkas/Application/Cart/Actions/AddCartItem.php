<?php

namespace App\Ahkas\Application\Cart\Actions;

use App\Ahkas\Application\Cart\Exceptions\InvalidQtyOrder;
use App\Ahkas\Domain\Cart\CartItemModel;
use App\Ahkas\Domain\Cart\CartModel;
use App\Ahkas\Domain\Product\ProductModel;
use App\Ahkas\Domain\Product\ProductPriceModel;
use PhpParser\JsonDecoder;

class AddCartItem
{

    public function __invoke(CartModel $cart, ProductModel $product, ProductPriceModel $productPrice, int $qty, float $discount = 0): CartItemModel
    {
        if ($qty <= 0) {
            throw new InvalidQtyOrder();
        }

        // if ($product->manageInventory() && !$product->hasAvailableInventory($qty)) {
        //     throw new InsufficientInventoryAvailable($product);
        // }

        $cartItem = CartItemModel::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->where('cart_item_id', null)
            ->where('options->id', $productPrice->id)
            ->first();

        if (is_null($cartItem)) {

            $originalPrice = $productPrice->originalPrice();
            $comparePrice = $productPrice->comparePrice($product->onSaleOff());

            $cartItem = CartItemModel::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'qty' => $qty,
                'discount_percent' => $discount,
                'price_per_item' => $originalPrice,
                'price_per_item_after_discount' => $comparePrice,
                'total_item_price' => $qty * $originalPrice,
                'total_item_price_after_discount' => $qty * $comparePrice,
                'options' => json_encode([
                    'id' => $productPrice->id,
                    'name' => $productPrice->name,
                    'original_price' => $originalPrice,
                    'compare_price' => $comparePrice,
                ]),
            ]);

            $cart->refreshCart()->save();
            return $cartItem;
        }

        $qty += $cartItem->qty;
        (new UpdateQtyCartItem)($cart, $cartItem, $qty);

        return $cartItem;
    }
}
