<?php

namespace App\Providers;

use App\Library\Bot;
use Illuminate\Support\ServiceProvider;

class BotServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('bot', function () {
            return new Bot();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
