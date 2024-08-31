<?php

namespace App\Ahkas\Application\Product;

use App\Ahkas\Domain\Product\ProductModel;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function App\Ahkas\Support\asJson;

/**
 * @author SOPHEAK
 */
class GetPromotionProductController
{
    public function __invoke(Request $request): JsonResponse
    {
        $product  = ProductModel::limit(5)
            ->with('category')
            ->with('brand')
            ->get();

        return asJson($product);
    }
}
