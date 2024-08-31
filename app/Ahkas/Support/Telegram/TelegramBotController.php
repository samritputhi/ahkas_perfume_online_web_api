<?php

namespace App\Ahkas\Support\Telegram;

use Illuminate\Http\Request;

class TelegramBotController
{
    public function __invoke(Request $request)
    {
        if (isset($request['message']['text']) && str_contains($request['message']['text'], '/groupid')) {
            $chatId = $request['message']['chat']['id'];
            $message = 'Group ID : ' . $chatId;
            return Telegram::send($chatId)->text($message);
        }

        return response(['message' => 'fail']);
    }
}
