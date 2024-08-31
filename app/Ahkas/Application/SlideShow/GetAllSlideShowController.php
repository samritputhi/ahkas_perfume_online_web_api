<?php

namespace App\Ahkas\Application\SlideShow;

use App\Ahkas\Domain\SlideShow\SlideShowModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function App\Ahkas\Support\asJson;

/**
 * @author SOPHEAK
 */
class GetAllSlideShowController
{
    public function __invoke(Request $request): JsonResponse
    {
        $item  = SlideShowModel::all();

        return asJson($item);
    }
}
