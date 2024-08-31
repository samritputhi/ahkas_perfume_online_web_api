<?php

namespace App\Ahkas\Domain\Order;

use App\Ahkas\Domain\Product\ProductModel;
use Database\Factories\OrderItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @author SOPHEAK
 */
class OrderItemModel extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'price_per_item' => 'float',
        'price_per_item_after_discount' => 'float',
    ];


    public function order(): BelongsTo
    {
        return $this->belongsTo(OrderModel::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(ProductModel::class);
    }

    public function promotion(): HasOne
    {
        return $this->hasOne(OrderItemPromotionModel::class, 'order_item_id');
    }

    protected static function newFactory(): OrderItemFactory
    {
        return OrderItemFactory::new();
    }
}
