<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalyticsDashboard extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'analytics_dashboard';

    protected $fillable = [
        'tenant_id',
        'survey_id',
        'dashboard_type',
        'data',
        'generated_at',
        'expires_at',
    ];

    protected $casts = [
        'data' => 'array',
        'generated_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}