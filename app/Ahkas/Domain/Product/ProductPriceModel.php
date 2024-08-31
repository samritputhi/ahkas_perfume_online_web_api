<?php

namespace App\Ahkas\Domain\Product;

use App\Ahkas\Support\Enums\DiscountType;
use Database\Factories\ProductPriceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @author SOPHEAK
 */
class ProductPriceModel extends Model
{
    use HasFactory;

    protected $table = 'product_prices';

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    protected $casts = [
        'price' => 'double',
    ];

    public function originalPrice(): float
    {
        return  $this->price;
    }

    public function comparePrice(mixed $discount): float
    {

        $value = $this->price;

        if (is_null($discount)) {
            return  $value;
        }

        if ($discount->type === DiscountType::PERCENTAGE) {
            return  $value - ($discount->amount * $value / 100);
        }
        return  $value - $discount->amount;
    }

    protected static function newFactory(): ProductPriceFactory
    {
        return ProductPriceFactory::new();
    }
}
