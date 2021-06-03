<?php


namespace App\Library;


use App\Library\Drivers\VKDriver;
use ATehnix\VkClient\Client;
use ATehnix\VkClient\Exceptions\VkException;
use ATehnix\VkClient\Requests\Request as VKRequest;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotSender
{
    public ?string $driver;
    public int $user_id;
    public int $date;

    public array $drivers;

    public function __construct(BotRequest $request) {
        $this->driver = $request->driver;
        $this->user_id = $request->user_id;
        $this->date = $request->date;

        $this->drivers = [
            'vk' => new VKDriver(),
        ];
    }

    public function send(string $message, BotKeyboard $keyboard = null){
        $driver = $this->driver.'Driver';
        return $this->{$driver}($this->user_id, $message, $keyboard);
    }

    public function vkDriver(int $user_id, string $message, BotKeyboard $keyboard = null) {
        $api = new Client("5.131");
        $api->setDefaultToken(env('VK_API_TOKEN'));
        $message = [
            'user_id' => $user_id,
            'random_id' => $this->date,
            "message" => $message,
        ];

        if($keyboard){
            $message['keyboard'] = $keyboard->vk();
        }

        try {
            return $api->send(new VKRequest('messages.send', $message))["response"];
        } catch (VkException $e) {
            Log::error($e->getMessage());
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
