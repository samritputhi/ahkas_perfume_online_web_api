<?php

namespace App\Ahkas\Domain\Product;

use App\Ahkas\Domain\Brand\BrandModel;
use App\Ahkas\Domain\Category\CategoryModel;
use App\Ahkas\Domain\Favorite\FavoriteModel;
use App\Ahkas\Domain\Discount\DiscountModel;
use App\Ahkas\Domain\Product\traits\ProductDiscountFeature;
use App\Ahkas\Domain\Product\traits\ProductFavoriteFeature;
use App\Ahkas\Domain\Product\traits\ProductPromotionFeature;
use Carbon\Carbon;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

/**
 * @author SOPHEAK
 */
class ProductModel extends Model
{
    use HasFactory,
        SoftDeletes,
        ProductFavoriteFeature,
        ProductDiscountFeature,
        ProductPromotionFeature,
        Searchable;

    protected $table = 'products';

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'discount',
        'prices',
    ];

    protected $appends = [
        'has_discount',
        'has_promotion',
        'discount_label',
        'promotion_label',
        'original_price',
        'compare_price',
        'is_favorite',
        'item_prices',
        'images',
    ];

    protected $casts = [
        'price' => 'double',
        'original_price' => 'double',
        'compare_price' => 'double',
        'image' => 'array',
    ];

    public function searchableAs(): string
    {
        return 'products_index';
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'price' => $this->price,
        ];
    }

    protected function getImagesAttribute()
    {
        $priceImages = $this->prices()
            ->where('image', '!=', null)
            ->pluck('image')
            ->toArray();
        return array_merge($this->image, $priceImages);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryModel::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(BrandModel::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(FavoriteModel::class, 'product_id', 'id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(ProductPriceModel::class, 'product_id', 'id')->orderBy('price');
    }

    public function discount(): MorphOne
    {
        return $this
            ->morphOne(DiscountModel::class, 'discountable')
            ->where('active', true)
            ->where('issued_at', '<=', Carbon::now())
            ->where('expired_at', '>', Carbon::now())
            ->orderByDesc('id');
    }

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }
}
