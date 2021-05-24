<?php

namespace Database\Factories;

use App\Models\WebhookService;
use Illuminate\Database\Eloquent\Factories\Factory;

class WebhookServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WebhookService::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'driver' => $this->faker->word,
        ];
    }
}
