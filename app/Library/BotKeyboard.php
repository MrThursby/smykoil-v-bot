<?php


namespace App\Library;


use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotKeyboard
{
    /** @var array[]  */
    public array $rows;
    public bool $inline = false;

    /**
     * BotKeyboard constructor.
     * @param array[] $keyboard
     * @param bool $inline
     */
    public function __construct(array $keyboard, bool $inline = false) {
        $this->rows = $keyboard;
        $this->inline = $inline;
    }

    /**
     * @param bool $bool
     * @return BotKeyboard
     */
    public function inline(bool $bool = true): self {
        $this->inline = $bool;
        return $this;
    }

    public function tg() {
        return (new Keyboard([
            'inline_keyboard' => collect($this->rows)->map(function ($row) {
                $buttons = [];
                foreach ($row as $text => $callback_data){
                    $buttons[] = compact('text', 'callback_data');
                }
                return $buttons;
            })->toArray(),
            'one_time_keyboard' => true
        ]))->inline();
    }

    public function vk() {
        return [
            'buttons' => collect($this->rows)->map(function ($row) {
                $buttons = [];
                foreach ($row as $label => $payload) {
                    $type = 'text';
                    $payload = ['command' => $payload];
                    $buttons[] = [
                        'action' => compact('type', 'label', 'payload'),
                        'color' => 'secondary'
                    ];
                }
                return $buttons;
            })->toArray(),
            'inline' => true
        ];
    }
}
