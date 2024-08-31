<?php

namespace App\Ahkas\Application\Brand;

use App\Ahkas\Domain\Brand\BrandModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function App\Ahkas\Support\asJson;

/**
 * @author SOPHEAK
 */
class GetAllBrandController
{
    public function __invoke(Request $request): JsonResponse
    {
        $item  = BrandModel::all();

        return asJson($item);
    }
}
