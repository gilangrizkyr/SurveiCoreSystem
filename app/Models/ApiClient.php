<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Encryptable;

class ApiClient extends Model
{
    use HasFactory, SoftDeletes, Encryptable;

    protected $encryptable = [
        'client_secret',
    ];

    protected $fillable = [
        'uuid',
        'tenant_id',
        'name',
        'client_id',
        'client_secret',
        'redirect_uris',
        'tier',
        'status',
    ];

    protected $casts = [
        'redirect_uris' => 'json',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function apiKeys()
    {
        return $this->hasMany(ApiKey::class , 'client_id');
    }
}