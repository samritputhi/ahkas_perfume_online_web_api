<?php

namespace App\Ahkas\Domain\User;

use App\Ahkas\Domain\Address\AddressModel;
use App\Ahkas\Domain\Favorite\FavoriteModel;
use App\Ahkas\Domain\NotificationMessage\Models\UserDeviceModel;
use App\Ahkas\Domain\Order\OrderModel;
use App\Ahkas\Domain\Search\RecentSearchModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @author SOPHEAK
 */
trait UserRelationshipMixin
{
    public function devices(): HasMany
    {
        return $this->hasMany(UserDeviceModel::class, 'user_id', 'id');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(FavoriteModel::class, 'user_id', 'id');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(AddressModel::class, 'user_id', 'id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(OrderModel::class, 'user_id', 'id');
    }

    public function recentSearches(): HasMany
    {
        return $this->hasMany(RecentSearchModel::class, 'user_id', 'id');
    }
}
