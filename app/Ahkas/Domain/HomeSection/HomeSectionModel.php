<?php

namespace App\Ahkas\Domain\HomeSection;

use App\Ahkas\Domain\Product\ProductModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @author SOPHEAK
 */
class HomeSectionModel extends Model
{
    use HasFactory;

    protected $table = 'home_sections';

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function products(): BelongsToMany
    {
        return $this->BelongsToMany(
            ProductModel::class,
            'home_section_products',
            'home_section_id',
            'product_id',
            'id',
        );
    }
}
