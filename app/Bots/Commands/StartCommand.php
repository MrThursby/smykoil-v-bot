<?php


namespace App\Bots\Commands;


use Illuminate\Support\Facades\Log;

class StartCommand implements CommandInterface
{

    public function __construct() {
        //
    }

    public static function getName(): string
    {
        return 'start';
    }

    public function execute(?array $params): void
    {
        var_dump('YES');
    }
}
