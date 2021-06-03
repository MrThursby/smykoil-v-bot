<?php

namespace App\Http\Controllers\BotHandler;

use App\Http\Controllers\Controller;
use App\Http\Requests\BotHandler\TgHandlerRequest;
use App\Services\BotHandler\BotHandlerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TgHandlerController extends Controller
{
    public function handle(TgHandlerRequest $request, BotHandlerService $handler): void
    {
        Log::info('Tg controller called');
        $handler->handleCommand($request->getCommand(), $request->getParameters());
    }
}
