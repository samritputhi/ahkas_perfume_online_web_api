<?php

namespace App\Ahkas\Domain\FlashSale;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @author SOPHEAK
 */
class FlashSaleProductModel extends Model
{
    use HasFactory;

    protected $table = 'flash_sale_products';

    protected $guarded = [];

    protected $hidden = [];
}
