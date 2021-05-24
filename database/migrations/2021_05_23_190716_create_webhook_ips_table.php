<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebhookIpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webhook_ips', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('service_id');

            $table->unsignedInteger('first_ip');
            $table->unsignedInteger('last_ip');

            $table->timestamps();

            $table->foreign('service_id')
                ->references('id')
                ->on('webhook_services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webhook_ips');
    }
}
