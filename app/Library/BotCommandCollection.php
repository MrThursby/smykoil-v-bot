<?php

declare(strict_types=1);

namespace App\Library;


use Closure;

class BotCommandCollection
{
    /** @var BotCommand[]  */
    protected array $commands = [];

    private array $lookupList = [];

    function add(string $path, string $query, callable|Closure $action): void
    {
        $command = new BotCommand($path, $query, $action);

        $this->commands[] = $command;
        $this->lookupList[$path][$query] = $command;
    }

    function find(string $path, string $command): ?BotCommand
    {
        if(!array_key_exists($path, $this->lookupList)){
            return null;
        }

        if(!array_key_exists($command, $this->lookupList[$path])){
            return null;
        }

        return $this->lookupList[$path][$command];
    }
}
