<?php

namespace App\Ahkas\Application\Product;

use App\Ahkas\Domain\Product\ProductModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function App\Ahkas\Support\asJson;
use function App\Ahkas\Support\asPagination;

/**
 * @author SOPHEAK
 */
class GetProductDetailController
{
    public function __invoke(int $id): JsonResponse
    {
        $product = ProductModel::find($id);
        if (is_null($product)) return response()->json('Not Found.', 404);
        $product->promotion = $product->promotion();
        return asJson($product);
    }
}
