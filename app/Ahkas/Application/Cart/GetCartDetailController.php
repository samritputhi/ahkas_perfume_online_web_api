<?php

namespace App\Ahkas\Application\Cart;

use App\Ahkas\Domain\User\UserModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function App\Ahkas\Support\asJson;

class GetCartDetailController
{
    public function __invoke(UserModel $user, Request $request): JsonResponse
    {

        $cart =  $cart = $user->cart;

        if (!$cart) {
            return asJson('Cart is empty.', 404);
        }

        return asJson($cart->refreshCart()->summary());
    }
}
