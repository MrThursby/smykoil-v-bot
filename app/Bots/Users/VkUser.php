<?php


namespace App\Bots\Users;


use ATehnix\VkClient\Client;
use ATehnix\VkClient\Requests\Request as VKRequest;
use Illuminate\Support\Facades\Log;

class VkUser implements BotUserInterface
{
    use BotUserTrait;

    public function __construct($id) {
        $api = new Client('5.103');
        $api->setDefaultToken(env('VK_API_TOKEN'));

        $this->id = $id;

        try {
            $user = $api->send(new VKRequest('users.get', [
                'user_ids' => $id,
                "fields" => 'screen_name',
            ]))["response"][0];

            $this->firstname = (string) $user["first_name"];
            $this->lastname = (string) $user["last_name"];
            $this->nickname = (string) $user["screen_name"];
        } catch (\Exception $exception){
            Log::error($exception);
            $this->firstname = null;
            $this->lastname = null;
            $this->nickname = null;
        }
    }
}
