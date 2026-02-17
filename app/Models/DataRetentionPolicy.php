<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRetentionPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'data_type',
        'retention_days',
        'auto_delete',
        'last_cleanup_at',
    ];

    protected $casts = [
        'auto_delete' => 'boolean',
        'last_cleanup_at' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}