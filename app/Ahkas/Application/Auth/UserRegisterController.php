<?php

namespace App\Ahkas\Application\Auth;

use App\Ahkas\Domain\User\UserModel;
use App\Ahkas\Support\Telegram\Telegram;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

use function App\Ahkas\Support\asJson;

/**
 * @author SOPHEAK
 */
class UserRegisterController
{
    public function __invoke(UserRegisterRequest $request): JsonResponse
    {

        if (UserModel::where('phone', $request->get('phone'))->first()) {
            return asJson(
                ['message' => 'exist',],
                400
            );
        }

        $user = UserModel::create([
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'name' => $request->name,
        ]);

        $token = $user->createToken($request->device_name)->plainTextToken;

        $this->sentTelegram($user);

        return response()->json(['token' => $token], 201);
    }

    private function sentTelegram(UserModel $model)
    {
        $text = "----- New Register -----\n"
            . "Name:\t{$model->name}\n"
            . "Phone:\t" . $model->phone . "\n";

        Telegram::send()->text($text);
    }
}
