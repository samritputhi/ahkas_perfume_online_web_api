<?php

namespace App\Ahkas\Application\Auth;

use App\Ahkas\Domain\User\UserModel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use function App\Ahkas\Support\asJson;

/**
 * @author SOPHEAK
 */
class CheckPhoneExistController
{
    /**
     * @throws \Exception
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required|digits_between:10,12',
        ]);

        if (UserModel::where('phone', $request->get('phone'))->first()) {
            return asJson(
                [
                    'message' => 'exist',
                ],
                200
            );
        }
        return asJson(
            [
                'message' => 'The given data was invalid.',
                'errors' => ['phone' =>  'The phone not found'],
            ],
            404
        );
    }
}
