<?php

namespace App\Ahkas\Domain\Category;

use App\Ahkas\Domain\Discount\DiscountModel;
use Carbon\Carbon;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @author SOPHEAK
 */
class CategoryModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';

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

    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }
}
