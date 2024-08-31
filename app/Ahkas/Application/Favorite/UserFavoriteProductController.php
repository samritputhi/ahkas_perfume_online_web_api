<?php

namespace App\Ahkas\Application\Favorite;

use Illuminate\Http\JsonResponse;
use App\Ahkas\Domain\Product\ProductModel;

class UserFavoriteProductController
{
    public function __invoke($id): JsonResponse
    {
        $item = ProductModel::find($id);
        if (is_null($item)) return response()->json('Not Found.', 404);
        $isFavorite = $item->toggleFavorite();

        return response()->json([
            'message' => $isFavorite ? 'Favourited.' : 'Unfavourited'
        ], 201);
    }
}
