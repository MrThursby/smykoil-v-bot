<?php


namespace App\Library\Drivers\Vk;


use App\Library\BotKeyboard;

class VkMessage
{
    public ?string $text;
    public ?int $date;
    public ?VkKeyboard $keyboard;

    public function send($user_id) {
        //

        return $this;
    }

    public function setText(string $text) {
        $this->text = $text;

        return $this;
    }

    public function setDate(int $date) {
        $this->date = $date;

        return $this;
    }

    public function setKeyboard(VkKeyboard $keyboard) {
        $this->keyboard = $keyboard;

        return $this;
    }
}
