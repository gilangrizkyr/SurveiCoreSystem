<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, Encryptable;

    protected $encryptable = [
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hasRole(string $role): bool
    {
        return $this->roles()->where('slug', '=', $role)->exists();
    }

    public function hasPermission(string $permission): bool
    {
        return $this->roles()
            ->whereHas('permissions', function ($query) use ($permission) {
            $query->where('slug', '=', $permission);
        })
            ->exists();
    }

    public function hasAnyPermission(array $permissions): bool
    {
        return $this->roles()
            ->whereHas('permissions', function ($query) use ($permissions) {
            $query->whereIn('slug', $permissions);
        })
            ->exists();
    }

    /**
     * Define Passport scopes for this user type.
     */
    public static function scopeDefinition(): array
    {
        return [
            'surveys.read' => 'Read surveys',
            'surveys.write' => 'Create and edit surveys',
            'surveys.delete' => 'Delete surveys',
            'responses.read' => 'View responses',
            'responses.write' => 'Submit responses',
            'responses.delete' => 'Delete responses',
            'analytics.read' => 'View analytics',
            'analytics.export' => 'Export analytics',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class , 'user_role');
    }

    public function tenants()
    {
        return $this->belongsToMany(Tenant::class , 'tenant_user')
            ->withPivot('roles')
            ->withTimestamps();
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class , 'creator_id');
    }

    public function responses()
    {
        return $this->hasMany(SurveyResponse::class , 'respondent_id');
    }
}