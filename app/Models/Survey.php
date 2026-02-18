<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'tenant_id',
        'creator_id',
        'template_id',
        'theme_id',
        'source_app_name',
        'source_app_url',
        'usage_context',
        'title',
        'description',
        'welcome_message',
        'thank_you_message',
        'status',
        'type',
        'settings',
        'metadata',
        'starts_at',
        'ends_at',
        'allow_multiple_submissions',
        'require_respondent_identity',
        'duplicate_prevention_method',
    ];

    protected $casts = [
        'settings' => 'json',
        'metadata' => 'json',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'allow_multiple_submissions' => 'boolean',
        'require_respondent_identity' => 'boolean',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class , 'creator_id');
    }

    public function sections()
    {
        return $this->hasMany(SurveySection::class);
    }

    public function responses()
    {
        return $this->hasMany(SurveyResponse::class);
    }
}