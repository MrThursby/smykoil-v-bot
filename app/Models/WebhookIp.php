<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebhookIp extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id', 'first_ip', 'last_ip'
    ];

    public function service() {
        return $this->belongsTo(WebhookService::class, 'service_id');
    }
}
