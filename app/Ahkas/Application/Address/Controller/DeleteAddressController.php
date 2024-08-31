<?php

namespace App\Ahkas\Application\Address\Controller;

use App\Ahkas\Domain\User\UserModel;
use Illuminate\Http\JsonResponse;


use function App\Ahkas\Support\asJson;

/**
 * @author SOPHEAK
 */
class DeleteAddressController
{
    public function __invoke(UserModel $user, int $id): JsonResponse
    {
        $address = $user->addresses->find($id);

        if (!$address) {
            return asJson('not_found', 404);
        }

        if ($address->is_default) {
            $user->addresses()->orderBy('id', 'DESC')->first()->update(['is_default' => true]);
        }

        $address->delete();

        return  asJson($user->addresses()->orderBy('id', 'DESC')->get());
    }
}
