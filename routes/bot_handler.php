<?php

use App\Http\Controllers\BotHandler\WelcomeController;
use App\Facades\BotFacade as Bot;

Bot::registerRoute('/bot_handler', function () {
    Bot::registerCommand('/start', [new WelcomeController, 'index']);
});

Bot::registerRoute('/vk_handler', function () {
    Bot::registerCommand('/com', function () {
        return 'ok';
    });
});
