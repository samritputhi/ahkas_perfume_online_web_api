<?php

namespace App\Ahkas\Domain\Product\traits;

use App\Ahkas\Support\Enums\DiscountType;

use function App\Ahkas\Support\priceFormat;

/**
 * @author SOPHEAK
 */
trait ProductDiscountFeature
{

    protected function getComparePriceAttribute()
    {

        if ($this->has_discount) {
            if ($this->prices->count() == 1) {
                return $this->priceAfterDiscount();
            }
            if ($this->prices->count() > 1) {
                // return as price range

                if ($this->has_discount) {
                    $lowPrice = $this->prices->first()->comparePrice($this->onSaleOff());
                    $highPrice = $this->prices->last()->comparePrice($this->onSaleOff());
                    return  $lowPrice . '-' .  $highPrice;
                }
            }
            return '--';
        }

        return $this->original_price;
    }

    protected function getOriginalPriceAttribute()
    {

        if ($this->prices->count() == 1) {
            return priceFormat($this->prices->first()->price);
        }

        if ($this->prices->count() > 1) {
            $lowPrice = $this->prices->first()->originalPrice();
            $highPrice = $this->prices->last()->originalPrice();
            return priceFormat($lowPrice)  . '-' . priceFormat($highPrice);
        }
        return '--';
    }

    private function priceAfterDiscount()
    {
        if ($this->prices->count() > 1) {
            return '--';
        }

        if ($this->has_discount && $this->prices->count() == 1) {
            $value = $this->prices->first()->price;
            if ($this->onSaleOff()->type === DiscountType::PERCENTAGE) {
                return priceFormat($value - ($this->onSaleOff()->amount * $value / 100));
            }
            return priceFormat($value - $this->onSaleOff()->amount);
        }
        return priceFormat($this->prices->first()->price);
    }

    protected function getHasDiscountAttribute()
    {
        return  !is_null($this->onSaleOff());
    }

    public function getDiscountLabelAttribute()
    {
        return $this->has_discount
            ? __('product.discount') . ' ' . ($this->onSaleOff()->type == DiscountType::FIXED_AMOUNT ? $this->discountValue() . '$' :
                $this->onSaleOff()->amount . '%')
            : '0';
    }

    public function getItemPricesAttribute()
    {
        if ($this->prices->count() == 1) {
            return [];
        }
        return $this->prices->map(function ($e) {
            return [
                'id' => $e->id,
                'name' => $e->name,
                'original_price' => $e->originalPrice(),
                'compare_price' => $e->comparePrice($this->onSaleOff()),
            ];
        });
    }

    public function onSaleOff()
    {
        return $this->discount ??
            $this->category->discount ??
            $this->brand->discount;
    }

    private function discountValue()
    {
        $price = $this->prices->first();
        if (is_null($price)) {
            return 0;
        }
        return $this->prices->first()->price - $this->onSaleOff()->amount;
    }
}
