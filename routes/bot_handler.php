<?php

use App\Http\Controllers\BotHandler\WelcomeController;
use App\Facades\BotFacade as Bot;
use App\Library\BotRequest;
use App\Library\BotSender;
use Illuminate\Support\Facades\Log;

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
