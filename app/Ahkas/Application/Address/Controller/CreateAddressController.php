<?php

namespace App\Ahkas\Application\Address\Controller;

use App\Ahkas\Application\Address\Request\CreateAddressRequest;
use App\Ahkas\Domain\Address\AddressModel;
use App\Ahkas\Domain\User\UserModel;
use Illuminate\Http\JsonResponse;


use function App\Ahkas\Support\asJson;

/**
 * @author SOPHEAK
 */
class CreateAddressController
{
    public function __invoke(CreateAddressRequest $request, UserModel $user): JsonResponse
    {
        $is_default = $request->is_default ??  $user->addresses->isEmpty();

        if ($is_default) {
            $user->addresses()->update(['is_default' => false]);
        }

        AddressModel::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'address' => $request->address,
            'is_default' => $is_default,
            'latitude' => $request->latitude ?? 0,
            'longitude' => $request->longitude ?? 0,
        ]);

        $address = $user->addresses()->orderBy('id', 'DESC')->get();
        return  asJson($address);
    }
}
