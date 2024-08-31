<?php

namespace App\Ahkas\Application\Notification;

use App\Ahkas\Domain\NotificationMessage\Models\UserDeviceModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function App\Ahkas\Support\asJson;

class RemoveUserDeviceController
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required'
        ]);

        UserDeviceModel::whereToken($request->token)
            ->whereUserId($request->user()->id)
            ->delete();

        return asJson([
            'message' => 'The device token has been deleted'
        ]);
    }
}
