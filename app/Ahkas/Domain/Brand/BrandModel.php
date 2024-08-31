<?php

namespace App\Ahkas\Domain\Brand;

use App\Ahkas\Domain\Discount\DiscountModel;
use Carbon\Carbon;
use Database\Factories\BrandFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



/**
 * @author SOPHEAK
 */
class BrandModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'brands';

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'Discount',
    ];

    public function discount(): MorphOne
    {
        return $this
            ->morphOne(DiscountModel::class, 'discountable')
            ->where('active', true)
            ->where('issued_at', '<=', Carbon::now())
            ->where('expired_at', '>', Carbon::now())
            ->orderByDesc('id');
    }

    protected static function newFactory(): BrandFactory
    {
        return BrandFactory::new();
    }
}
