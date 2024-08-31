<?php

namespace App\Ahkas\Application\Cart;

use App\Ahkas\Application\Cart\Actions\UpdateQtyCartItem;
use App\Ahkas\Domain\Cart\CartItemModel;
use App\Ahkas\Domain\User\UserModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function App\Ahkas\Support\asJson;

class UpdateQtyCartItemController
{
    public function __invoke(UserModel $user, Request $request): JsonResponse
    {

        $cartItem = CartItemModel::find($request->cart_item_id);

        if (is_null($cartItem)) return asJson('Not found.', 404);

        $cart = (new UpdateQtyCartItem)($user->cart, $cartItem, $request->qty);

        if (!$cart) {
            return asJson('Cart is empty.', 404);
        }

        return asJson($cart->refreshCart()->summary());
    }
}
