<?php

namespace App\Ahkas\Domain\Order;

use App\Ahkas\Admin\Resources\ReceiveOrderResource;
use App\Ahkas\Domain\NotificationMessage\Enums\NotificationTypeEnum;
use App\Ahkas\Domain\NotificationMessage\Models\NotificationMessageModel;
use App\Ahkas\Domain\Order\enum\OrderStatusEnum;
use App\Ahkas\Domain\User\UserModel;
use Carbon\Carbon;
use Database\Factories\OrderFactory;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @author SOPHEAK
 */
class OrderModel extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $guarded = [];

    // protected $hidden = [
    //     'created_at',
    //     'updated_at',
    // ];

    protected $casts = [
        'price_per_item' => 'float',
        'status' => OrderStatusEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItemModel::class, 'order_id', 'id');
    }

    public function summary()
    {

        $orderItems = $this->items->map(function ($item) {
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
            'id' => $this->id,
            'order_number' => $this->order_number,
            'order_data' => $this->created_at,
            'status' => 'pending',
            'items' => $orderItems,
            'payment_summary' => [
                'shipping_cost' => $this->total_shipping_cost,
                'coupon_discount' => $this->coupon_reduction,
                'total_discount' => 0,
                'subtotal' => $this->total_item_price,
                'grand_total' => $this->total_item_price_after_discount,
            ]
        ];
    }

    public function displayItemPromotion(OrderItemModel $item)
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

    public function updateOrderStatus()
    {
        $newStatus = OrderStatusEnum::PENDING;
        $timestampField = '';

        switch ($this->status) {
            case OrderStatusEnum::PENDING:
                $newStatus = OrderStatusEnum::CONFIRM;
                $timestampField = 'confirm_at';
                break;
            case OrderStatusEnum::CONFIRM:
                $newStatus = OrderStatusEnum::DELIVERY;
                $timestampField = 'delivery_at';
                break;
            case OrderStatusEnum::DELIVERY:
                $newStatus = OrderStatusEnum::RECEIVE;
                $timestampField = 'completed_at';
                break;
            default:
                return;
        }

        if ($newStatus && $timestampField) {
            $this->update([
                'status' => $newStatus,
                $timestampField => Carbon::now(),
            ]);
            $this->notifyOrderStatus($newStatus);
        }
    }



    private function notifyOrderStatus(OrderStatusEnum $status)
    {
        NotificationMessageModel::create([
            'type' => NotificationTypeEnum::USER,
            'title' => 'order_num : ' . $this->order_number,
            'notification' => 'your order has been ' . $status->name,
            'publish_at' => Carbon::now(),
            'meta' => json_encode([
                'user_id' => $this->user->id,
                'order_id' => $this->id,
            ]),
        ]);
    }

    protected static function newFactory(): OrderFactory
    {
        return OrderFactory::new();
    }
}
