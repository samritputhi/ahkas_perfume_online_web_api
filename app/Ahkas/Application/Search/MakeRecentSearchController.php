<?php

namespace App\Ahkas\Application\Search;

use App\Ahkas\Domain\User\UserModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function App\Ahkas\Support\asJson;

/**
 * @author SOPHEAK
 */
class MakeRecentSearchController
{
    public function __invoke(UserModel $user, Request $request): JsonResponse
    {
        $searches  = $user->recentSearches()->create([
            'search_text' => $request->search_text,
        ]);

        return asJson($searches);
    }
}
