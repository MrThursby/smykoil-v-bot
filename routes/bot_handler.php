<?php

use App\Http\Controllers\BotHandler\WelcomeController;
use App\Facades\BotFacade as Bot;
use App\Library\BotRequest;
use App\Library\BotSender;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

Bot::registerRoute('/bot_handler', function () {
    Bot::registerCommand('/start', function (BotRequest $request) {
        $sender = new BotSender($request);
        $response = $sender->send('Привет, '.$request->first_name);
        $response = collect($response)->toJson();
        Log::info($response);

        return 'ok';
    });

    Bot::registerCommand('vk_confirmation', function () {
        return response(env('VK_CONFIRMATION'));
    });
});

Route::get('/bot/set_wh', function () {
    dd(Telegram::setWebhook([
        'url' => env('TELEGRAM_WEBHOOK_URL')
    ]));
});
