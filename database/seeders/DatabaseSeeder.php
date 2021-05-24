<?php

namespace Database\Seeders;

use App\Models\WebhookIp;
use App\Models\WebhookService;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // Add VK IPs
        WebhookService::factory()->create(['title' => 'ВКонтакте', 'driver' => 'vk']);
        $this->addIpFromCidr(1, '79.137.139.0/24');
        $this->addIpFromCidr(1, '79.137.164.0/24');
        $this->addIpFromCidr(1, '79.137.180.0/24');
        $this->addIpFromCidr(1, '87.240.128.0/18');
        $this->addIpFromCidr(1, '87.240.166.0/24');
        $this->addIpFromCidr(1, '87.240.167.0/24');
        $this->addIpFromCidr(1, '93.186.224.0/21');
        $this->addIpFromCidr(1, '93.186.232.0/21');
        $this->addIpFromCidr(1, '95.142.192.0/20');
        $this->addIpFromCidr(1, '95.142.192.0/21');
        $this->addIpFromCidr(1, '95.213.0.0/18');
        $this->addIpFromCidr(1, '95.213.44.0/24');
        $this->addIpFromCidr(1, '95.213.45.0/24');
        $this->addIpFromCidr(1, '185.32.248.0/22');

        // Add Telegram IPs
        WebhookService::factory()->create(['title' => 'Телеграм', 'driver' => 'tg']);
        $this->addIpFromCidr(2, '149.154.160.0/22');
        $this->addIpFromCidr(2, '149.154.164.0/22');
        $this->addIpFromCidr(2, '91.108.4.0/22');
        $this->addIpFromCidr(2, '91.108.56.0/22');
        $this->addIpFromCidr(2, '95.161.64.0/20');
    }

    public function addIpFromCidr(int $service_id, string $cidr) {
        $range = [];

        $cidr = explode('/', $cidr);

        $range[0] = long2ip((ip2long($cidr[0])) & ((-1 << (32 - (int)$cidr[1]))));
        $range[1] = long2ip((ip2long($range[0])) + pow(2, (32 - (int)$cidr[1])) - 1);

        $first_ip = ip2long($range[0]);
        $last_ip = ip2long($range[1]);

        WebhookIp::factory()->create(compact('service_id', 'first_ip', 'last_ip'));
    }

    /*public function addIp(int $service_id, string $ip) {
        $first_ip = $ip;
        $last_ip = $ip;
        WebhookIp::factory()->create(compact('service_id', 'first_ip', 'last_ip'));
    }*/
}
