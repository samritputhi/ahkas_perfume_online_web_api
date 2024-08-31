<?php

namespace App\Ahkas\Application\Home;

use App\Ahkas\Domain\HomeSection\HomeSectionModel;
use App\Ahkas\Domain\User\UserModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function App\Ahkas\Support\asJson;

/**
 * @author SOPHEAK
 */
class HomeBadgeController
{
    public function __invoke(UserModel $user): JsonResponse
    {
        $cartCount = $user->cart?->items?->count() ?? 0;
        $notifyCount = $user->notificationMessages?->count() ?? 0;

        return asJson([
            'cart_badge' => $cartCount,
            'notify_badge' => $notifyCount,
        ]);
    }
}
