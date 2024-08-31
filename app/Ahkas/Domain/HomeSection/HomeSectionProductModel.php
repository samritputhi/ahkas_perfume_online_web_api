<?php

namespace App\Ahkas\Domain\HomeSection;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @author SOPHEAK
 */
class HomeSectionProductModel extends Model
{
    use HasFactory;

    protected $table = 'home_section_products';

    protected $guarded = [];

    protected $hidden = [];
}
