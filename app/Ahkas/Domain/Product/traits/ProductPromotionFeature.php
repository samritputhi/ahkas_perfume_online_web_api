<?php

namespace App\Ahkas\Domain\Product\traits;

use App\Ahkas\Domain\Product\ProductModel;
use App\Ahkas\Domain\Promotion\PromotionRuleModel;

/**
 * @author SOPHEAK
 */
trait ProductPromotionFeature
{

    public function getPromotionLabelAttribute()
    {
        if ($this->has_promotion) {
            $promotion = $this->onPromotion();
            return __('product.buy') . ' '
                . $promotion->required_quantity . ' '
                . __('product.get') . ' '
                . $promotion->free_quantity;
        }
        return '';
    }


    public function promotion()
    {
        if ($this->has_promotion) {
            $promotionProduct = ProductModel::find($this->onPromotion()->free_product_id);
            return    [
                'id' => $promotionProduct->id,
                'name' => $promotionProduct->name,
                'description' => $promotionProduct->description,
                'image' => $promotionProduct->image,
                'label' => $this->promotionLabel(),
            ];
        }
        return [];
    }

    public function getHasPromotionAttribute()
    {
        return  !is_null($this->onPromotion());
    }

    private function promotionLabel()
    {
        $promotion = $this->onPromotion();
        if ($promotion->discount_percentage > 0) {
            return __('product.discount') . ' ' . $promotion->discount_percentage . ' %';
        }
        return '+' . $this->onPromotion()->free_quantity . ' ' . __('product.free');
    }
    private function onPromotion()
    {
        $promotionRule = PromotionRuleModel::firstWhere('product_id', $this->id);
        if ($promotionRule && $promotionRule->promotion) {
            if ($promotionRule->promotion->isActive()) {
                return $promotionRule;
            }
        }
    }
}
