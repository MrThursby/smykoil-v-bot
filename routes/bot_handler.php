<?php

use App\Http\Controllers\BotHandler\WelcomeController;
use App\Facades\BotFacade as Bot;
use App\Library\BotKeyboard;
use App\Library\BotRequest;
use App\Library\BotSender;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

Bot::registerRoute('/bot_handler', function () {
    Bot::registerCommand('/start', function (BotRequest $request) {
        $keyboard = (new BotKeyboard([
            [['Привет' => '/hello'], ['Пока' => '/buy']],
            [['Ещё' => '/etc']],
        ]))->inline(false);
        $sender = new BotSender($request);
        $sender->send('Привет, '.$request->first_name, $keyboard);
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

Route::get('/test/kb', function (BotRequest $request) {
    $request->user_id = 123;
    $request->date = 123;
    $keyboard = (new BotKeyboard([
        ['Привет' => '/hello', 'Пока' => '/buy'],
        ['Ещё' => '/etc'],
    ]))->inline()->tg();
    dd($keyboard);
});
