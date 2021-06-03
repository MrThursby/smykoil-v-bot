<?php

return [
    'senders' => [
        'tg' => \App\Bots\Senders\Drivers\TgSenderDriver::class,
        'vk' => \App\Bots\Senders\Drivers\VkSenderDriver::class,
    ],

    'keyboards' => [
        //
    ],
];
