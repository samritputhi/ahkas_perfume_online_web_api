<?php

namespace App\Ahkas\Application\Address\Controller;

use App\Ahkas\Domain\User\UserModel;
use Illuminate\Http\JsonResponse;


use function App\Ahkas\Support\asJson;

/**
 * @author SOPHEAK
 */
class GetAllAddressController
{
    public function __invoke(UserModel $user): JsonResponse
    {
        $addresses  = $user->addresses()->orderBy('id', 'DESC')->get();

        // Check if all items have 'is_default' set to false
        $allDefaultFalse = $addresses->every(function ($address) {
            return $address->is_default === false;
        });

        if ($allDefaultFalse && $addresses->isNotEmpty()) {
            // If all items have 'is_default' == false, then set 'is_default' = true for the first item
            $firstAddress = $addresses->first();

            // Update the 'is_default' column in the database
            $firstAddress->is_default = true;
            $firstAddress->save();
        }

        return asJson($addresses);
    }
}
