<?php

namespace App\Ahkas\Domain\Search;

use Database\Factories\PopularSearchFactory;
use Database\Factories\RecentSearchFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @author SOPHEAK
 */
class PopularSearchModel extends Model
{
    use HasFactory;

    protected $table = 'popular_searches';

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected static function newFactory(): PopularSearchFactory
    {
        return PopularSearchFactory::new();
    }
}
