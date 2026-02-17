<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Encryptable;

class Integration extends Model
{
    use HasFactory, Encryptable;

    protected $encryptable = [
        'credentials',
    ];

    protected $fillable = [
        'tenant_id',
        'type',
        'credentials',
        'settings',
        'is_active',
    ];

    protected $casts = [
        'credentials' => 'encrypted',
        'settings' => 'json',
        'is_active' => 'boolean',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}