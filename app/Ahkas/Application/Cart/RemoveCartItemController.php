<?php

namespace App\Ahkas\Application\Cart;

use App\Ahkas\Application\Cart\Actions\RemoveCartItem;
use App\Ahkas\Domain\Cart\CartItemModel;
use App\Ahkas\Domain\User\UserModel;
use Illuminate\Http\JsonResponse;

use function App\Ahkas\Support\asJson;

class RemoveCartItemController
{
    /**
     * @throws \Throwable
     */
    public function __invoke(UserModel $user, CartItemModel $cartItem): JsonResponse
    {
        $cart = (new RemoveCartItem)($user->cart, $cartItem);

        if (!$cart) {
            return asJson('Cart is empty.', 404);
        }

        return asJson($cart->summary());
    }
}
