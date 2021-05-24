<?php

declare(strict_types=1);

namespace App\Library;


use Closure;
use Illuminate\Support\Str;

class BotCommand
{
    public string $path;
    public string $command;

    /** @var callable|Closure */
    public $action;

    public function __construct(string $path, string $command, callable|Closure $action)
    {
        $this->path = $path;

        $command = Str::start($command, '/');
        $command = Str::replaceFirst('/', '', $command);

        $this->command = $command;
        $this->action = $action;
    }

    public function run(array $params): mixed
    {
        $action = $this->action;

        if($action instanceof Closure){
            return $action(...$params);
        }

        if(is_callable($action)){
            return call_user_func_array($action, $params);
        }

        return null;
    }
}
