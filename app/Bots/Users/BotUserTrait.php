<?php


namespace App\Bots\Users;


trait BotUserTrait
{

    public ?int $id;
    public ?string $firstname;
    public ?string $lastname;
    public ?string $nickname;

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }
}
