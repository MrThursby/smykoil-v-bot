<?php


namespace App\Bots\Users;


class TgUser implements BotUserInterface
{
    use BotUserTrait;

    public function __construct($id, $firstname, $lastname, $nickname)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->nickname = $nickname;
    }
}
