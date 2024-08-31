<?php

namespace App\Ahkas\Domain\Search;

use Database\Factories\RecentSearchFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @author SOPHEAK
 */
class RecentSearchModel extends Model
{
    use HasFactory;

    protected $table = 'recent_searches';

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'user_id',
    ];

    protected static function newFactory(): RecentSearchFactory
    {
        return RecentSearchFactory::new();
    }
}
