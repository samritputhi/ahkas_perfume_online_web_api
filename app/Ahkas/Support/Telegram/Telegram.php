<?php

namespace App\Ahkas\Support\Telegram;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class Telegram
{

    public function __construct(
        protected string  $apiKey,
        protected ?string $chatId = null
    ) {
    }

    protected function botEndpoint(): string
    {
        return 'https://api.telegram.org/bot' . $this->apiKey . '/sendMessage?chat_id=';
    }

    public static function send(string $chatId = null): self
    {

        return new Telegram(
            apiKey: config('services.ahkas_telegram.apiKey'),
            chatId: $chatId ?? config('services.ahkas_telegram.chatId')
        );
    }

    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    public function to(string $chatId): self
    {
        $this->chatId = $chatId;
        return $this;
    }

    public function text(string $message): Response
    {
        //-572271196
        //$endpoint = "https://api.telegram.org/bot1871663595:AAEjPrJsT9vIMcEQjxrwwgAKBkIP1k2z4tM/sendMessage?chat_id={$userId}&text={$message}";
        $message = $message . "ENV:\t" . config('app.env')  . "\n";
        $endpoint = $this->botEndpoint() . $this->chatId . '&text=' . $message;
        return Http::get($endpoint);
    }
}
