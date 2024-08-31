<?php

namespace App\Ahkas\Application\User;

use App\Ahkas\Application\User\Account\Request\UserChangeProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function App\Ahkas\Support\asJson;
use function App\Ahkas\Support\fileToHash;
use function App\Ahkas\Support\uploadImage;

/**
 * @author SOPHEAK
 */
class UserChangeProfileController
{

    public function __invoke(Request $request): JsonResponse
    {
        if (empty($request->profile)) {
            return asJson(['profile' => 'required']);
        }

        $request->user()->update(
            [
                'profile' => Storage::disk()->put('profile', $request->profile),
            ]
        );

        return asJson($request->user());
    }
}
