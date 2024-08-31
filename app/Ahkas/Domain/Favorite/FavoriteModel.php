<?php

namespace App\Ahkas\Domain\Favorite;

use Illuminate\Database\Eloquent\Model;

/**
 * @author SOPHEAK
 */
class FavoriteModel extends Model
{

    protected $table = 'favorites';

    public $guarded = [];
}
