<?php


namespace App\Bots\Users;


interface BotUserInterface
{
    public function getDriver(): string;
    public function getId(): int;
    public function getFirstname(): string;
    public function getLastname(): string;
    public function getNickname(): string;
}
