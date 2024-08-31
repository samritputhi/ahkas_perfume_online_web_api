<?php

namespace App\Ahkas\Domain\Cart;

use App\Ahkas\Domain\Cart\traits\CartPromotion;
use App\Ahkas\Domain\User\UserModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @author SOPHEAK
 */
class CartModel extends Model
{

    use CartPromotion;

    protected $table = 'carts';

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'price_per_item' => 'float',
        'total_shipping_cost' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class);
    }


    public function items(): HasMany
    {
        return $this->hasMany(CartItemModel::class, 'cart_id', 'id');
    }

    public function isEmpty(): bool
    {
        return $this->items()->count() === 0;
    }

    public function refreshCart()
    {
        $cart =  $this->refreshPromotion();

        $totalItemPrice = 0;
        $totalItemPriceAfterDiscount = 0;
        foreach ($cart->items as $item) {
            $totalItemPrice += $item->total_item_price;
            $totalItemPriceAfterDiscount += $item->total_item_price_after_discount;
        }
        $cart->total_item_price = $totalItemPrice;
        $cart->total_item_price_after_discount = $totalItemPriceAfterDiscount;

        return $cart;
    }

    public function displayItemPromotion(CartItemModel $item)
    {
        if ($item->promotion) {
            $product = $item->promotion->product;
            if ($item->promotion->discount_percent == 100) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'image' => $product->image,
                    'qty' => $item->promotion->qty,
                    'label' => '+ ' . $item->promotion->qty . ' ' . __('free'),
                ];
            } else {
                return [
                    'label' => 'discount ' . $product->name . ' ' . $item->promotion->discount_percent . ' %'
                ];
            }
        }
    }

    public function summary(): array
    {
        $cartItems = $this->items->map(function ($item) {
            $product = [
                'id' => $item->id,
                'product_id' => $item->product->id,
                'name' => $item->product->name,
                'image' => $item->product->image,
                'qty' => $item->qty,
                'price_per_item' => $item->price_per_item,
                'price_per_item_after_discount' => $item->price_per_item_after_discount,
                'has_discount' => $item->product->has_discount,
                'discount_label' => $item->product->discount_label,
                'promotion' => $this->displayItemPromotion($item),
                'options' => json_decode($item->options),
            ];

            return $product;
        });
        return [
            'badge' => $cartItems->count(),
            'items' => $cartItems,
            'payment_summary' => [
                'shipping_cost' => $this->total_shipping_cost,
                'coupon_discount' => $this->getCouponReductionAmount(),
                'total_discount' => $this->getTotalDiscount(),
                'subtotal' => $this->getSubTotal(),
                'grand_total' => $this->getGrandTotal(),
            ]
        ];
    }

    // private function

    private function getTotalDiscount(): float
    {
        $total = $this->total_item_price - $this->total_item_price_after_discount;
        return round($total, 2);
    }

    private function getSubTotal(): float
    {
        return round($this->total_item_price, 2);
    }

    private function getGrandTotal(): float
    {
        $total = $this->total_item_price_after_discount;

        $total = $total + $this->total_shipping_cost;

        $total = $total - $this->getCouponReductionAmount();

        return round($total, 2);
    }

    private function getCouponReductionAmount(): float
    {
        return round(0, 2);
    }
}
