<?php

namespace App\Ahkas\Application\Product;

use App\Ahkas\Domain\FlashSale\FlashSaleModel;
use App\Ahkas\Domain\Product\ProductModel;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function App\Ahkas\Support\asJson;
use function App\Ahkas\Support\makeFavorite;

/**
 * @author SOPHEAK
 */
class GetFlashSaleProductController
{
    public function __invoke(Request $request): JsonResponse
    {

        $flashSale = FlashSaleModel::active()->first();
        if (!$flashSale) {
            return asJson([], 404);
        }

        $product = $flashSale->products;

        return asJson([
            'expired_at' => $flashSale->expired_at,
            'products' => $product,
        ]);
    }
}
