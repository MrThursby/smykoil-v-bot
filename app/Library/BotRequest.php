<?php

declare(strict_types=1);

namespace App\Library;


use App\Models\WebhookIp;
use App\Models\WebhookService;
use ATehnix\VkClient\Client;
use ATehnix\VkClient\Exceptions\VkException;
use Illuminate\Http\Request;
use ATehnix\VkClient\Requests\Request as VKRequest;
use Illuminate\Support\Facades\Log;

class BotRequest
{
    public Request $request;

    public ?string $driver;

    public string $command;
    /** @var string[] */
    public array $parameters = [];

    public int $user_id;
    public string $username;
    public string $first_name;
    public string $last_name;
    public int $date;

    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->setDriver($request->ip());
        if($this->driver == null){
            $this->command = 'unknown_service';
        } else {
            $driver = $this->driver.'Driver';
            $this->{$driver}($request);
        }
    }

    public function setDriver(string $ip) {
        $ip = ip2long($ip);
        Log::info("$ip");
        $webhookIp = WebhookIp::query()
            ->where('first_ip', '<=', $ip)
            ->where('last_ip', '>=', $ip)
            ->first();

        if($webhookIp){
            $this->driver = $webhookIp->service->driver;
            return null;
        }

        $this->driver = null;
    }

    public function tgDriver(Request $request) {
        Log::info('TgDriver has been used');
        Log::info($request->json('message.text') ?? $request->json('callback_query.data'));
        if($request->has('message')){
            $q = $request->json('message.text');
            $this->user_id = (int) $request->json('message.from.id');
            $this->first_name = (string) $request->json('message.from.first_name');
            $this->last_name = (string) $request->json('message.from.last_name');
            $this->username = (string) $request->json('message.from.username');
        }

        elseif($request->has('callback_query')){
            $q = $request->json('callback_query.data');
            $this->user_id = (int) $request->json('callback_query.from.id');
            $this->first_name = (string) $request->json('callback_query.from.first_name');
            $this->last_name = (string) $request->json('callback_query.from.last_name');
            $this->username = (string) $request->json('callback_query.from.username');
        }

        else {
            $this->command = 'unknown';
            return null;
        }

        $this->parseQuery($q);
    }

    public function vkDriver(Request $request) {
        if($request->json('type') == 'confirmation') {
            $this->command = 'vk_confirmation';
        }

        if($request->json('type') == 'message_new') {
            $q = $request->json('object.message.text');
            $this->user_id = (int) $request->json('object.message.from_id');
            $this->date = (int) $request->json('object.message.date');

            $api = new Client("5.131");
            $api->setDefaultToken(env('VK_API_TOKEN'));

            try {
                $user = $api->send(new VKRequest('users.get', [
                    'user_ids' => $this->user_id,
                    "fields" => 'screen_name',
                ]))["response"][0];
                $this->first_name = $user["first_name"];
                $this->last_name = $user["last_name"];
                $this->username = $user["screen_name"];
            } catch (VkException $e) {
                Log::info($e->getTraceAsString());
                $this->username = 'unknown';
                $this->first_name = 'unknown';
                $this->last_name = 'unknown';
            }

            $this->parseQuery($q);
        }

        else {
            return null;
        }
    }

    public function parseQuery(string $q): void
    {
        $q = explode(' ', $q);
        $this->command = $q[0];
        Log::info('Command '.$this->command.' has been used');

        if(count($q) > 1){
            unset($q[0]);
            $this->parameters = $q;
        }
    }

    public function getCommand(): string
    {
        return $this->command;
    }
}
