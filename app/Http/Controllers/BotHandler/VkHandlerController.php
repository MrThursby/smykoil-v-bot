<?php

namespace App\Http\Controllers\BotHandler;

use App\Http\Controllers\Controller;
use App\Http\Requests\BotHandler\VkHandlerRequest;
use App\Services\BotHandler\BotHandlerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VkHandlerController extends Controller
{
    public function handle(VkHandlerRequest $request, BotHandlerService $handler): string
    {
        Log::info('Vk controller called');
        $handler->handleCommand($request->getCommand(), $request->getParameters());
        return 'ok';
    }
}
