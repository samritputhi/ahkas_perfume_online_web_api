<?php

namespace App\Ahkas\Application\Favorite;

use App\Ahkas\Domain\Product\ProductModel;
use App\Ahkas\Domain\User\UserModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function App\Ahkas\Support\asPagination;

class GetFavoriteProductController
{
    public function __invoke(UserModel $user, Request $request): JsonResponse
    {

        $itemIds = $user->favorites()->pluck('product_id')->toArray();

        $paginator = ProductModel::whereIn('id', $itemIds)->paginate(perPage: $request->per_page);

        return asPagination($paginator);
    }
}
