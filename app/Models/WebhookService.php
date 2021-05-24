<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebhookService extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'driver'
    ];

    public function ips() {
        return $this->hasMany(WebhookIp::class, 'service_id');
    }
}
