<?php

namespace App\Ahkas\Application\Search;

use App\Ahkas\Domain\User\UserModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function App\Ahkas\Support\asJson;

/**
 * @author SOPHEAK
 */
class DeleteRecentSearchController
{
    public function __invoke(UserModel $user, int $id): JsonResponse

    {
        $recentSearch = $user->recentSearches->find($id);

        if (!$recentSearch) {
            return asJson('not_found', 404);
        }

        $recentSearch->delete();

        return asJson($user->recentSearches()->orderBy('id', 'DESC')->get());
    }
}
