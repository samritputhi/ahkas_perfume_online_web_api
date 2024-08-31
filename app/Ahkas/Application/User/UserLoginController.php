<?php

namespace App\Ahkas\Application\User;

use App\Ahkas\Domain\User\UserModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

use function App\Ahkas\Support\asJson;

class UserLoginController
{
    public function __invoke(Request $request): JsonResponse
    {

        $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        $user = UserModel::firstWhere('phone', $request->phone);

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'phone' => ['The provided credential are incorrect.']
            ]);
        }

        return asJson([
            'token' => $user->createToken($request->phone)->plainTextToken
        ]);
    }
}
