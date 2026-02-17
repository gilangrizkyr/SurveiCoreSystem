<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiUsageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'api_key_id',
        'endpoint',
        'method',
        'status_code',
        'response_time',
        'ip_address',
        'user_agent',
        'request_signature',
    ];

    public function client()
    {
        return $this->belongsTo(ApiClient::class);
    }

    public function apiKey()
    {
        return $this->belongsTo(ApiKey::class);
    }
}