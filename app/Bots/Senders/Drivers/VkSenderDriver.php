<?php


namespace App\Bots\Senders\Drivers;


class VkSenderDriver implements BotSenderDriverInterface
{
    public function send(int $user_id, string $message, array $keyboard): bool
    {
        // TODO: Implement send() method.
        return false;
    }

    public static function getName(): string
    {
        return 'vk';
    }
}
