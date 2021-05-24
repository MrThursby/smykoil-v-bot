<?php


namespace App\Library;


class BotKeyboard
{
    /** @var array[]  */
    public array $keyboard;
    public bool $inline = false;

    /**
     * BotKeyboard constructor.
     * @param array[] $keyboard
     * @param bool $inline
     */
    public function __construct(array $keyboard, bool $inline = false) {
        $this->keyboard = $keyboard;
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
}
