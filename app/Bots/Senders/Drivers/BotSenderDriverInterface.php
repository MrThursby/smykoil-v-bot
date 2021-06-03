<?php


namespace App\Bots\Senders\Drivers;


interface BotSenderDriverInterface
{
    public static function getName(): string;

    public function send(int $user_id, string $message, array $keyboard): bool;
}
