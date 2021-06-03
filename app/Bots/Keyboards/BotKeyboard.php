<?php


namespace App\Bots\Keyboards;


class BotKeyboard
{
    /** @var array[][]|null */
    public ?array $buttons;
    public bool $inline;

    /**
     * @param array[][] $buttons
     *
     * $buttons должна иметь такой формат: [
     *     [                                      // Строка в клавиатуре
     *         ['Начать' => ['/start', 'primary'] // кнопка
     *         ['Начать' => ['/start'] // Кнопка без указания цвета (по умолчанию - secondary)
     *     ]
     * ];
     *
     * Цвета поддерживаются не во всех мессенджерах,
     * драйвера будут использовать их, если они поддерживаются;
     *
     * Цвета:
     * - primary - акцентный цвет,
     * - secondary - серый / белый,
     * - danger - красный,
     * - success - зелёный;
     */
    public static function make(array $buttons, bool $inline = false) {
        $keyboard = new self();
        $keyboard->buttons = $buttons;
        $keyboard->inline = $inline;
    }
}
