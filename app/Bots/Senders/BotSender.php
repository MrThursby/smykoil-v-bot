<?php


namespace App\Bots\Senders;


use App\Bots\Senders\Drivers\BotSenderDriverInterface;
use App\Bots\Senders\Drivers\VkSenderDriver;
use App\Bots\Users\BotUserInterface;
use App\Library\Drivers\VKDriver;

class BotSender
{
    public BotUserInterface $asker;
    public BotSenderDriverInterface $driver;

    public function answer(string $message, array $keyboard) {
        $this->setDriver($this->asker->getDriver())
            ->send($this->asker->id, $message, $keyboard);
    }

    public function send(int $user_id, $message, array $keyboard) {
        $this->driver->send($user_id, $message, $keyboard);
    }

    public function setDriver(string $driver) {
        $this->driver = new VkSenderDriver();
        return $this;
    }
}
