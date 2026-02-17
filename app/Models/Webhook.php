<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Webhook extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'survey_id',
        'url',
        'events',
        'secret',
        'is_active',
        'retry_limit',
        'timeout_seconds',
    ];

    protected $casts = [
        'events' => 'json',
        'is_active' => 'boolean',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function logs()
    {
        return $this->hasMany(WebhookLog::class);
    }
}