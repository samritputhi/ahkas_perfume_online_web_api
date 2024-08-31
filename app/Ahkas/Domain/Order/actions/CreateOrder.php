<?php

namespace App\Ahkas\Domain\Order\actions;

use App\Ahkas\Domain\Cart\CartModel;
use App\Ahkas\Domain\Order\OrderModel;
use Closure;

use function App\Ahkas\Support\unique_random;

class CreateOrder
{
    public function __invoke(CartModel $cart, string $payment, string $adress): OrderModel
    {
        $order = OrderModel::create([
            'order_number' => unique_random('orders', 'order_number', 8),
            'user_id' => $cart->user_id,
            'total_item_price' => $cart->total_item_price,
            'total_item_price_after_discount' => $cart->total_item_price_after_discount,
            'total_shipping_cost' => $cart->total_shipping_cost,
            'coupon_code' => $cart->coupon_code,
            'coupon_reduction' => $cart->coupon_reduction,
            'coupon_meta' => $cart->coupon_meta,
            'additional_info' => json_encode([
                'payment_method' => $payment,
                'address' => $adress,
            ]),
        ]);

        $orderLines = $cart
            ->items
            ->map($this->toOrderLines())
            ->toArray();

        $order->items()->createMany($orderLines);

        foreach ($order->items as $item) {

            $cartItem = $cart->items()->firstWhere('product_id', $item->product_id);

            if ($cartItem && $cartItem->promotion) {
                $item->promotion()->create([
                    'product_id' => $cartItem->promotion->product_id,
                    'qty' => $cartItem->promotion->qty,
                    'discount_percent' => $cartItem->promotion->discount_percent,
                ]);
            }
        }

        $cart->delete();

        return $order;
    }



    private function toOrderLines(): Closure
    {
        return function ($item) {

            $line = [];
            $line['product_id'] = $item['product_id'];
            $line['qty'] = $item['qty'];
            $line['discount_percent'] = $item['discount_percent'];
            $line['price_per_item'] = $item['price_per_item'];
            $line['price_per_item_after_discount'] = $item['price_per_item_after_discount'];
            $line['total_item_price'] = $item['total_item_price'];
            $line['total_item_price_after_discount'] = $item['total_item_price_after_discount'];
            $line['options'] = $item['options'];
            // promotion
            // $line['promotion']['product_id'] = $item->promotion->id;
            // $line['promotion']['qty'] = $item->promotion->qty;
            // $line['promotdion']['discount_percent'] = $item->promotion->discount_percent;
            return $line;
        };
    }
}
