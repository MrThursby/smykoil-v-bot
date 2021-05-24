<?php

namespace Database\Factories;

use App\Models\WebhookIp;
use App\Models\WebhookService;
use Illuminate\Database\Eloquent\Factories\Factory;

class WebhookIpFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WebhookIp::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'service_id' => WebhookService::query()
                ->orderBy('id', 'desc')
                ->first(),
            'first_ip' => ip2long($this->faker->ipv4),
            'last_ip' => ip2long($this->faker->ipv4),
        ];
    }
}
