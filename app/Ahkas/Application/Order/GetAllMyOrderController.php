<?php

namespace App\Ahkas\Application\Order;

use App\Ahkas\Domain\User\UserModel;
use Illuminate\Http\Request;

use function App\Ahkas\Support\asPagination;

class GetAllMyOrderController
{

    public function __invoke(Request $request, UserModel $user)
    {
        $orders = $user->orders()->paginate(perPage: $request->per_page);

        $mapping = $orders->map(function ($product) {
            return $product->summary();
        });
        $datas = $orders->setCollection(collect($mapping));

        return asPagination($datas);
    }
}
