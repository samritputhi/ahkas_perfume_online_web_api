<?php

return [
    // Telegram logger bot token
    'token' => env('PERFUME_TELEGRAM_TOKEN'),

    // Telegram chat id
    'chat_id' => env('PERFUME_TELEGRAM_GROUP'),

    // Blade Template to use formatting logs
    'template' => env('TELEGRAM_LOGGER_TEMPLATE', 'laravel-telegram-logging::standard'),

    // Proxy server
    'proxy' => env('TELEGRAM_LOGGER_PROXY', ''),

    // Telegram API host without trailling slash
    'api_host' => env('TELEGRAM_LOGGER_API_HOST', 'https://api.telegram.org'),

    // Telegram sendMessage options: https://core.telegram.org/bots/api#sendmessage
    'options' => [
        // 'parse_mode' => 'html',
        // 'disable_web_page_preview' => true,
        // 'disable_notification' => false
    ]
];
