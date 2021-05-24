<?php

use App\Http\Controllers\BotHandler\WelcomeController;
use App\Facades\BotFacade as Bot;
use App\Library\BotRequest;
use Illuminate\Support\Facades\Log;

Bot::registerRoute('/bot_handler', function () {
    Bot::registerCommand('/start', function (BotRequest $request) {
        Log::info(
            'Driver: '.$request->driver.
            'Username: '.$request->username.
            'User Id: '.$request->user_id.
            'Firstname: '.$request->first_name.
            'Lastname: '.$request->last_name
        );
    });

    Bot::registerCommand('vk_confirmation', function () {
        return response(env('VK_CONFIRMATION'));
    });
});
