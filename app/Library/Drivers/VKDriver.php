<?php

declare(strict_types=1);

namespace App\Library\Drivers;


use App\Library\BotKeyboard;
use ATehnix\VkClient\Client;
use ATehnix\VkClient\Exceptions\VkException;
use ATehnix\VkClient\Requests\Request as VKRequest;
use Illuminate\Support\Facades\Log;
use function Symfony\Component\Translation\t;

class VKDriver
{
    public string $name = 'vk';
    public Client $api;

    public array $message;

    public function __construct() {
        $this->api = new Client('5.131');
        $this->api->setDefaultToken(env('VK_API_TOKEN'));
    }

    function send(): bool
    {
        try {
            $this->api->send(new VKRequest('messages.send', $this->message))["response"];
            return true;
        } catch (VkException $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function makeMessage(int $user_id, string $text, int $date, BotKeyboard $keyboard) {
        $message = [
            'user_id' => $user_id,
            'random_id' => $date,
            "message" => $text,
        ];

        if($keyboard){
            $message['keyboard'] = $this->makeKeyboard($keyboard);
        }

        $this->message = $message;

        return $this;
    }

    function makeKeyboard(BotKeyboard $keyboard):array
    {
        return [
            'buttons' => $this->convertKeyboardRows($keyboard->rows),
            'inline' => true
        ];
    }

    public function makeButton(string $text, string $command): array
    {
        return [
            'action' => [
                'type' => 'text',
                'label' => $text,
                'payload' => $command
            ],
            'color' => 'secondary'
        ];
    }

    public function convertKeyboardRows(array $rows): array
    {
        return collect($rows)->map(function ($row) {

            $buttons = [];

            foreach ($row as $text => $command) {
                $buttons[] = $this->makeButton($text, $command);
            }

            return $buttons;

        })->toArray();
    }
}
