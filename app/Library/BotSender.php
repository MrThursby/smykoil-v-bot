<?php


namespace App\Library;


use ATehnix\VkClient\Client;
use ATehnix\VkClient\Exceptions\VkException;
use ATehnix\VkClient\Requests\Request as VKRequest;

class BotSender
{
    public ?string $driver;
    public int $user_id;

    public function __construct(BotRequest $request) {
        $this->driver = $request->driver;
        $this->user_id = $request->user_id;
    }

    public function send(string $message, array $keyboard = null){
        return $this->{$this->driver.'Driver'}($this->user_id, $message, $keyboard);
    }

    public function vkDriver(int $user_id, string $message, array $keyboard = null) {
        $api = new Client("5.131");
        $api->setDefaultToken(env('VK_API_TOKEN'));

        try {
            return $api->send(new VKRequest('messages.send', [
                'user_id' => $user_id,
                "message" => $message,
            ]))["response"];
        } catch (VkException $e) {
            return null;
        }
    }

    public function tgDriver(int $user_id, string $message, array $keyboard = null) {
        return null;
    }
}
