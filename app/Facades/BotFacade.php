<?php

declare(strict_types=1);

namespace App\Facades;

use Closure;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void registerRoute(string $path, Closure $callback)
 * @method static void registerCommand(string $path, callable|Closure $callback)
 */
class BotFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'bot';
    }
}
