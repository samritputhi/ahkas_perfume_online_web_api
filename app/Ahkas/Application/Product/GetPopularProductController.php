<?php

namespace App\Ahkas\Application\Product;

use App\Ahkas\Domain\Product\ProductModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function App\Ahkas\Support\asJson;
use function App\Ahkas\Support\makeFavorite;

/**
 * @author SOPHEAK
 */
class GetPopularProductController
{
    public function __invoke(Request $request): JsonResponse
    {
        $product  = ProductModel::inRandomOrder()
            ->limit(5)
            ->with('category')
            ->with('brand')
            ->get();

        return asJson($product);
    }
}
