<?php

namespace App\Ahkas\Application\Cart;

use App\Ahkas\Application\Cart\Actions\AddCartItem;
use App\Ahkas\Application\Cart\Actions\InitializeCart as ActionsInitializeCart;
use App\Ahkas\Application\Cart\Exceptions\InvalidQtyOrder;
use App\Ahkas\Domain\Product\ProductModel;
use App\Ahkas\Domain\User\UserModel;
use Illuminate\Http\Request;

use function App\Ahkas\Support\asJson;

class AddCartItemController
{
    public function __invoke(Request $request, UserModel $user)
    {
        $product = ProductModel::find($request->product_id);
        $productPrice = $product->prices->first();

        if ($request->has('option_id') && $request->option_id != 0) {
            $productPrice = $product->prices->firstWhere('id', $request->option_id);
        }

        $cart = $user->cart;

        if (!$cart) {
            $cart = (new ActionsInitializeCart)($user->id);
        }

        try {
            (new AddCartItem)(
                $cart,
                $product,
                $productPrice,
                $request->qty,
            );
        } catch (InvalidQtyOrder $e) {
            return asJson($e->getMessage(), 400);
        }

        return asJson([
            'message' => 'Item was added to cart.',
            'badge' => $cart->items->count(),
        ], 201);
    }
}
