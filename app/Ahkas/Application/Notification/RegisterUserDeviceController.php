<?php

namespace App\Ahkas\Application\Notification;

use App\Ahkas\Domain\NotificationMessage\Models\UserDeviceModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function App\Ahkas\Support\asJson;

class RegisterUserDeviceController
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required|string',
            'type' => 'required|string'
        ]);

        $isDeviceExist = UserDeviceModel::whereUserId($request->user()->id)
            ->whereToken($request->token)
            ->count();

        if ($isDeviceExist) {
            return asJson(['message' => 'the device already exist.']);
        }

        UserDeviceModel::create([
            'user_id' => $request->user()->id,
            'token' => $request->token,
            'type' => $request->type
        ]);

        return asJson(['message' => 'the device register successfully'], 201);
    }
}
