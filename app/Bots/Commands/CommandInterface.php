<?php


namespace App\Bots\Commands;


interface CommandInterface
{
    public static function getName():string;
    public function execute(?array $params):void;
}
