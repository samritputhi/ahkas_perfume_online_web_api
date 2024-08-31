<?php

namespace App\Ahkas\Domain\Cart;

use App\Ahkas\Domain\Product\ProductModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @author SOPHEAK
 */
class CartItemPromotionModel extends Model
{

    protected $primaryKey = null;

    public $incrementing = false;

    protected $table = 'cart_item_promotions';

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [];


    public function cartItem(): BelongsTo
    {
        return $this->belongsTo(CartItemModel::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(ProductModel::class);
    }
}
