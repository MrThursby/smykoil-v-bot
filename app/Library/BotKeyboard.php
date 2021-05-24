<?php


namespace App\Library;


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
}
