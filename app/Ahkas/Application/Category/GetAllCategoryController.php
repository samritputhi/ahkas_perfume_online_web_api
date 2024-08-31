<?php

namespace App\Ahkas\Application\Category;

use App\Ahkas\Domain\Category\CategoryModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function App\Ahkas\Support\asJson;

/**
 * @author SOPHEAK
 */
class GetAllCategoryController
{
    public function __invoke(Request $request): JsonResponse
    {
        $item  = CategoryModel::all();

        return asJson($item);
    }
}
