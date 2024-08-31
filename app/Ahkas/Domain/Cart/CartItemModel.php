<?php

namespace App\Ahkas\Domain\Cart;

use App\Ahkas\Domain\Product\ProductModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @author SOPHEAK
 */
class CartItemModel extends Model
{

    protected $table = 'cart_items';

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'price_per_item' => 'float',
        'price_per_item_after_discount' => 'float',
    ];


    public function cart(): BelongsTo
    {
        return $this->belongsTo(CartModel::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(ProductModel::class);
    }

    public function promotion(): HasOne
    {
        return $this->hasOne(CartItemPromotionModel::class, 'cart_item_id');
    }
}
