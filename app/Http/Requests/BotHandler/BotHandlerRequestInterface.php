<?php


namespace App\Http\Requests\BotHandler;


use App\Bots\Users\BotUserInterface;

interface BotHandlerRequestInterface
{
    public function getCommand():string;
    public function getUser():BotUserInterface;
}
