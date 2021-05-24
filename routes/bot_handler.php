<?php

use App\Http\Controllers\BotHandler\WelcomeController;
use App\Facades\BotFacade as Bot;
use Illuminate\Support\Facades\Log;

Bot::registerRoute('/bot_handler', function () {
    Bot::registerCommand('/start', [new WelcomeController, 'index']);

    Bot::registerCommand('vk_confirmation', function () {
        Log::info('Vk confirm started');
        return response(env('VK_CONFIRMATION'));
    });
});
