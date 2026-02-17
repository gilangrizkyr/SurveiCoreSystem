<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateLimit extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'endpoint',
        'max_requests',
        'window_seconds',
    ];

    public function client()
    {
        return $this->belongsTo(ApiClient::class);
    }
}