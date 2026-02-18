<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait RestrictsToSuperAdmin
{
    public static function canViewAny(): bool
    {
        /** @var User */
        $user = auth()->user();
        return $user && $user->hasRole('super_admin');
    }

    public static function canCreate(): bool
    {
        /** @var User */
        $user = auth()->user();
        return $user && $user->hasRole('super_admin');
    }

    public static function canEdit(Model $record): bool
    {
        /** @var User */
        $user = auth()->user();
        return $user && $user->hasRole('super_admin');
    }

    public static function canDelete(Model $record): bool
    {
        /** @var User */
        $user = auth()->user();
        return $user && $user->hasRole('super_admin');
    }
}