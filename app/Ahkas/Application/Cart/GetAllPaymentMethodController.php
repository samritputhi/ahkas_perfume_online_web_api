<?php

namespace App\Ahkas\Application\Cart;

use App\Ahkas\Domain\PaymentMethod\PaymentMethodModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function App\Ahkas\Support\asJson;

/**
 * @author SOPHEAK
 */
class GetAllPaymentMethodController
{
    public function __invoke(Request $request): JsonResponse
    {
        $item  = PaymentMethodModel::all();

        return asJson($item);
    }
}
