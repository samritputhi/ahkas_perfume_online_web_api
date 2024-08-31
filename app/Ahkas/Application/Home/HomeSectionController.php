<?php

namespace App\Ahkas\Application\Home;

use App\Ahkas\Domain\HomeSection\HomeSectionModel;
use App\Ahkas\Domain\Product\ProductModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function App\Ahkas\Support\asJson;

/**
 * @author SOPHEAK
 */
class HomeSectionController
{
    public function __invoke(Request $request): JsonResponse
    {
        $sections = HomeSectionModel::with('products')->get();

        return asJson($sections);
    }
}
