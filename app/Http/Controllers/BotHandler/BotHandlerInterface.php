<?php


namespace App\Http\Controllers\BotHandler;


use App\Http\Requests\BotHandler\BotHandlerRequestInterface;

interface BotHandlerInterface
{
    public function handle(BotHandlerRequestInterface $request);
}
