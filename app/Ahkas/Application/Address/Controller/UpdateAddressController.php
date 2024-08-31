<?php

namespace App\Ahkas\Application\Address\Controller;

use App\Ahkas\Application\Address\Request\CreateAddressRequest;
use App\Ahkas\Domain\User\UserModel;
use Illuminate\Http\JsonResponse;


use function App\Ahkas\Support\asJson;

/**
 * @author SOPHEAK
 */
class UpdateAddressController
{
    public function __invoke(CreateAddressRequest $request, UserModel $user, int $id): JsonResponse
    {
        $address = $user->addresses->find($id);

        if (!$address) {
            return asJson('not_found', 404);
        }

        if ($request->is_default) {
            $user->addresses()->update(['is_default' => false]);
        }

        $address->update([
            'title' => $request->title,
            'address' => $request->address,
            'is_default' => $request->is_default,
            'latitude' => $request->latitude ?? $address->latitude,
            'longitude' => $request->longitude ?? $address->longitude,
        ]);

        $addresses = $user->addresses()->get();
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

        return  asJson($addresses);
    }
}
