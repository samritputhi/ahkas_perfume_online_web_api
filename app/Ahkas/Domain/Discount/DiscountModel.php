<?php

namespace App\Ahkas\Domain\Discount;

use App\Ahkas\Support\Enums\DiscountType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @author SOPHEAK
 */
class DiscountModel extends Model
{
    use HasFactory;

    protected $table = 'discounts';

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'type' => DiscountType::class,
        'active' => 'boolean'
    ];

    public function discountable(): MorphTo
    {
        return $this->morphTo();
    }
}
