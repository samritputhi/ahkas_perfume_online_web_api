<?php

namespace App\Ahkas\Application\Search;

use App\Ahkas\Domain\User\UserModel;
use Illuminate\Http\JsonResponse;

use function App\Ahkas\Support\asJson;

/**
 * @author SOPHEAK
 */
class GetRecentSearchController
{
    public function __invoke(UserModel $user): JsonResponse
    {
        $searches  = $user->recentSearches()->orderBy('id', 'DESC')->get();

        return asJson($searches);
    }
}
