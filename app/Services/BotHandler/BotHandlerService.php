<?php


namespace App\Services\BotHandler;


use App\Http\Requests\BotHandler\BotHandlerRequestInterface;
use App\Bots\Commands\CommandInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use ReflectionClass;
use Symfony\Component\Finder\Finder;

class BotHandlerService
{
    private array $commands = [];

    public function __construct()
    {
        $this->loadCommands(app_path('Bots\Commands'));
    }

    function handleCommand(string $command, ?array $params): void
    {
        $this->getCommand($command)?->execute($params);
    }

    private function getCommand(string $command): ?CommandInterface
    {
        if(!array_key_exists($command, $this->commands)){
            return null;
        }

        //$command =  new $this->commands[$command];

        //app()->bind(CommandInterface::class);
        $command = app()->make($this->commands[$command]);

        if(!($command instanceof CommandInterface)){
            return null;
        }

        return $command;
    }

    private function loadCommands($paths) {
        $paths = array_unique(Arr::wrap($paths));

        $paths = array_filter($paths, function ($path) {
            return is_dir($path);
        });

        if (empty($paths)) {
            return;
        }

        $namespace = app()->getNamespace();

        foreach ((new Finder)->in($paths)->files() as $command) {
            $command = $namespace.str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($command->getRealPath(), realpath(app_path()).DIRECTORY_SEPARATOR)
                );

            if (is_subclass_of($command, CommandInterface::class) &&
                ! (new ReflectionClass($command))->isAbstract()) {

                $command_name = call_user_func([$command, 'getName']);

                $this->commands[$command_name] = $command;
            }
        }
    }
}
