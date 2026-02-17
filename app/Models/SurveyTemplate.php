<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'name',
        'description',
        'category',
        'structure',
        'is_public',
    ];

    protected $casts = [
        'structure' => 'json',
        'is_public' => 'boolean',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class , 'template_id');
    }
}