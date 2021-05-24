<?php


namespace App\Library;


use ATehnix\VkClient\Client;
use ATehnix\VkClient\Exceptions\VkException;
use ATehnix\VkClient\Requests\Request as VKRequest;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotSender
{
    public ?string $driver;
    public int $user_id;
    public int $date;

    public function __construct(BotRequest $request) {
        $this->driver = $request->driver;
        $this->user_id = $request->user_id;
        $this->date = $request->date;
    }

    public function send(string $message, BotKeyboard $keyboard = null){
        $driver = $this->driver.'Driver';
        return $this->{$driver}($this->user_id, $message, $keyboard);
    }

    public function vkDriver(int $user_id, string $message, BotKeyboard $keyboard = null) {
        $api = new Client("5.131");
        $api->setDefaultToken(env('VK_API_TOKEN'));

        try {
            return $api->send(new VKRequest('messages.send', [
                'user_id' => $user_id,
                'random_id' => $this->date,
                "message" => $message,
            ]))["response"];
        } catch (VkException $e) {
            return null;
        }
    }

    public function tgDriver(int $user_id, string $message, BotKeyboard $keyboard = null) {
        $send = [
            'chat_id' => $user_id,
            'text' => $message,
        ];

        if($keyboard){
            $send['reply_markup'] = $keyboard->tg();
        }

        return Telegram::sendMessage($send);
    }
}
