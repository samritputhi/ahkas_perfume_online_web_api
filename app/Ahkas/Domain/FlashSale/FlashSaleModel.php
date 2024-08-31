<?php

namespace App\Ahkas\Domain\FlashSale;

use App\Ahkas\Domain\Product\ProductModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
// use Illuminate\Database\Query\Builder;

/**
 * @author SOPHEAK
 */
class FlashSaleModel extends Model
{
    use HasFactory;

    protected $table = 'flash_sales';

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function scopeActive(Builder $query)
    {
        $query->where('issued_at', '<', Carbon::now())
            ->where('expired_at', '>', Carbon::now());
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->issued_at > Carbon::now()) {
                    return 'pending';
                } else if ($this->expired_at <= Carbon::now()) {
                    return 'expired';
                } else {
                    return 'active';
                }
            }
        );
    }

    public function products(): BelongsToMany
    {
        return $this->BelongsToMany(
            ProductModel::class,
            'flash_sale_products',
            'flash_sale_id',
            'product_id',
            'id',
        );
    }
}
