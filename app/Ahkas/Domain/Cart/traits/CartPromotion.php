<?php

namespace App\Ahkas\Domain\Cart\traits;

use App\Ahkas\Domain\Cart\CartItemModel;
use App\Ahkas\Domain\Cart\CartModel;
use App\Ahkas\Domain\Promotion\PromotionModel;

trait CartPromotion
{
    public function refreshPromotion()
    {
        $promotions = PromotionModel::where('active', true)->get();

        $this->removePromotionFromItemCart();

        foreach ($promotions as $promotion) {

            $rules = $promotion->rules;

            if ($this->cartMeetsPromotionCriteria($this, $rules)) {

                $this->applyPromotionToCart($this, $rules);
            }
        }

        return $this->refresh();
    }

    protected function cartMeetsPromotionCriteria(CartModel $cart, $rules)
    {
        foreach ($rules as $rule) {

            foreach ($cart->items as $item) {

                if ($rule->product_id == $item->product_id && $item->qty >= $rule->required_quantity) {
                    return true;
                }
            }
        }
        return false;
    }

    protected function applyPromotionToCart(CartModel $cart, $rules)
    {
        foreach ($rules as $rule) {

            foreach ($cart->items as $item) {

                if ($rule->product_id == $item->product_id && $item->qty >= $rule->required_quantity) {
                    $item->promotion()->create([
                        'product_id' => $rule->free_product_id,
                        'qty' => $rule->free_quantity == 0 ? 1 : $rule->free_quantity,
                        'discount_percent' => $rule->free_quantity == 0 ?  $rule->discount_percentage : 100,
                    ]);
                }
            }
        }
        return false;
    }

    protected function removePromotionFromItemCart()
    {
        foreach ($this->items as $item) {
            $item->promotion()->delete();
        }
    }
}
