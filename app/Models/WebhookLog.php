<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebhookLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'webhook_id',
        'event',
        'payload',
        'status_code',
        'response_body',
        'attempt_number',
        'delivered_at',
        'failed_at',
    ];

    protected $casts = [
        'payload' => 'json',
        'delivered_at' => 'datetime',
        'failed_at' => 'datetime',
    ];

    public function webhook()
    {
        return $this->belongsTo(Webhook::class);
    }
}