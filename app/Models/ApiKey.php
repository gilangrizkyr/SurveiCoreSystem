<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Encryptable;

class ApiKey extends Model
{
    use HasFactory, Encryptable;

    protected $encryptable = [
        'secret',
    ];

    protected $fillable = [
        'client_id',
        'key',
        'secret',
        'name',
        'scopes',
        'ip_whitelist',
        'rate_limit',
        'expires_at',
        'last_used_at',
        'revoked_at',
    ];

    protected $casts = [
        'scopes' => 'json',
        'ip_whitelist' => 'json',
        'expires_at' => 'datetime',
        'last_used_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(ApiClient::class , 'client_id');
    }
}