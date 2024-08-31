<?php

namespace App\Ahkas\Domain\Order;

use App\Ahkas\Domain\Product\ProductModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @author SOPHEAK
 */
class OrderItemPromotionModel extends Model
{

    protected $primaryKey = null;

    public $incrementing = false;

    protected $table = 'order_item_promotions';

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [];


    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItemModel::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(ProductModel::class);
    }
}
