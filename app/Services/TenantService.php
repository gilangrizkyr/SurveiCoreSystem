<?php

namespace App\Services;

use App\Models\Tenant;
use Illuminate\Support\Str;

class TenantService
{
    public function createTenant(array $data): Tenant
    {
        if (!isset($data['uuid'])) {
            $data['uuid'] = (string)Str::uuid();
        }
        if (!isset($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        return Tenant::create($data);
    }

    public function getTenantBySlug(string $slug): ?Tenant
    {
        return Tenant::where('slug', $slug)->first();
    }
}