<?php

namespace App\Ahkas\Application\Search;

use App\Ahkas\Domain\Search\PopularSearchModel;
use App\Ahkas\Domain\User\UserModel;
use Illuminate\Http\JsonResponse;

use function App\Ahkas\Support\asJson;

/**
 * @author SOPHEAK
 */
class GetPopularSearchController
{
    public function __invoke(UserModel $user): JsonResponse
    {
        $searches  = PopularSearchModel::orderBy('id', 'DESC')->get()->pluck('search_text');

        return asJson($searches);
    }
}
