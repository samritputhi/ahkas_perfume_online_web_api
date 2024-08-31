<?php

namespace App\Ahkas\Domain\Product\traits;

use App\Ahkas\Domain\Favorite\FavoriteModel;
use Auth;

/**
 * @author SOPHEAK
 */
trait ProductFavoriteFeature
{
    public function getIsFavoriteAttribute()
    {
        return $this->isFavorited();
    }
    public function toggleFavorite($user_id = null): bool
    {
        $this->isFavorited($user_id) ? $this->removeFavorite($user_id) : $this->addFavorite($user_id);
        return $this->isFavorited($user_id);
    }

    public function isFavorited($user_id = null): bool
    {
        return $this->favorites()->where('user_id', ($user_id) ? $user_id : Auth::id())->exists();
    }

    private function addFavorite($user_id = null)
    {
        $favorite = new FavoriteModel(['user_id' => ($user_id) ? $user_id : Auth::id()]);
        $this->favorites()->save($favorite);
    }

    private function removeFavorite($user_id = null)
    {
        $this->favorites()->where('user_id', ($user_id) ? $user_id : Auth::id())->delete();
    }
}
