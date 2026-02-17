<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyTheme extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'name',
        'primary_color',
        'secondary_color',
        'font_family',
        'logo_url',
        'background_image',
        'custom_css',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class , 'theme_id');
    }
}