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

    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->setDriver($request->ip());
        if($this->driver == null){
            $this->command = 'unknown_service';
        } else {
            $this->{$this->driver.'Driver'}($request);
        }
    }

    public function setDriver(string $ip) {
        Log::info('set driver for ip: '.$ip);
        $ip = ip2long($ip);
        Log::info('set driver for (int) $ip: '.$ip);
        $webhookIp = WebhookIp::query()
            ->where('first_ip', '>=', $ip)
            ->where('last_ip', '<=', $ip)
            ->get()->first();
        if($webhookIp)Log::info('WebhookIp finded: '.$webhookIp->id);

        if($webhookIp){
            $this->driver = $webhookIp->service->driver;
        }

        $this->driver = null;
    }

    public function tgDriver(Request $request) {
        if($request->has('message')){
            $q = $request->json('message.text');
            $this->user_id = (int) $request->json('message.from.id');
            $this->first_name = (string) $request->json('message.from.first_name');
            $this->last_name = (string) $request->json('message.from.last_name');
            $this->username = (string) $request->json('message.from.username');
        }

        if($request->has('callback_query')){
            $q = $request->json('callback_query.data');
            $this->user_id = (int) $request->json('callback_query.from.id');
            $this->first_name = (string) $request->json('callback_query.from.first_name');
            $this->last_name = (string) $request->json('callback_query.from.last_name');
            $this->username = (string) $request->json('callback_query.from.username');
        }

        else {
            return null;
        }

        $this->parseQuery($q);
    }

    public function vkDriver(Request $request) {
        Log::info('Use vk driver');
        if($request->json('type') == 'confirmation') {
            $this->command = 'vk_confirmation';
        }

        if($request->json('type') == 'message') {
            $q = $request->json('object.text');
            $this->user_id = (int) $request->json('object.from_id');

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
