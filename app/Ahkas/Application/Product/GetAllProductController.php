<?php

namespace App\Ahkas\Application\Product;

use App\Ahkas\Domain\Product\ProductModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function App\Ahkas\Support\asJson;
use function App\Ahkas\Support\asPagination;
use function App\Ahkas\Support\makeFavorite;

/**
 * @author SOPHEAK
 */
class GetAllProductController
{
    public function __invoke(Request $request): JsonResponse
    {
        if ($request->has('category_id')) {
            return $this->byCategory($request);
        }

        return $this->all($request);
    }

    protected function byCategory(Request $request): JsonResponse
    {
        // $item = ItemModel::whereCategoryId($request->category_id)
        //     ->whereStatus(ItemStatusEnum::ON_SALE)
        //     ->with('user')->orderBy('id', 'DESC')
        //     ->paginate(perPage: $request->per_page);
        // $item =  makeFavorite($item);
        // return asJson($item);
        return asJson([]);
    }

    protected function all(Request $request): JsonResponse
    {
        $paginator = ProductModel::with('category')
            ->with('brand')
            ->paginate(perPage: $request->per_page);

        return asPagination($paginator);
    }
}
