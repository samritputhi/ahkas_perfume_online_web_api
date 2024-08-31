<?php

namespace App\Ahkas\Application\Address\Controller;

use App\Ahkas\Domain\User\UserModel;
use Illuminate\Http\JsonResponse;


use function App\Ahkas\Support\asJson;

/**
 * @author SOPHEAK
 */
class UpdateDefaultAddressController
{
    public function __invoke(UserModel $user, int $id): JsonResponse
    {


        $address = $user->addresses->find($id);

        if (!$address) {
            return asJson('not_found', 404);
        }
        $user->addresses()->update([
            'is_default' => false,
        ]);
        $address->update([
            'is_default' => true,
        ]);

        return  asJson($user->addresses()->orderBy('id', 'DESC')->get());
    }
}
