<?php

declare(strict_types=1);

namespace App\Library;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Bot
{
    protected string $route;
    protected BotCommandCollection $commands;

    public function __construct()
    {
        $this->commands = new BotCommandCollection();
    }

    public function registerCommand(string $command, callable|Closure $action): void
    {
        $this->commands->add($this->route, $command, $action);
    }

    # Register Laravel Route
    public function registerRoute(string $path, Closure $commands): void
    {
        $this->setRoute($path);

        // Register commands
        $commands($this);

        Route::post($path, function (Request $request, ...$params) {
            return $this->handle($request, $params);
        });
    }

    public function handle(Request $request, array $params): mixed
    {
        $botRequest = new BotRequest($request);

        $command = $this->commands
            ->find($request->route()->uri, $botRequest->getCommand());

        if(!$command) {
            return null;
        }

        $params = array_merge([$botRequest], $params);

        return $command->run($params);
    }

    public function setRoute(string $path): void
    {
        $path = $this->convertPath($path);

        $this->route = $path;
    }

    public function convertPath(string $path): string
    {
        $path = Str::start($path, '/');
        $path = Str::replaceFirst('/', '', $path);

        return $path;
    }
}
