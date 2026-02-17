<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'domain',
        'database',
        'settings',
        'status',
    ];

    protected $casts = [
        'settings' => 'json',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class , 'tenant_user')
            ->withPivot('roles')
            ->withTimestamps();
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }

    public function apiClients()
    {
        return $this->hasMany(ApiClient::class);
    }

    public function settingRecords()
    {
        return $this->hasMany(TenantSetting::class);
    }
}