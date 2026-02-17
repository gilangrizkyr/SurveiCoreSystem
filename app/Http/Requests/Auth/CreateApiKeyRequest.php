<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class CreateApiKeyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => 'required|exists:api_clients,id',
            'name' => 'required|string|max:255',
            'scopes' => 'nullable|array',
            'ip_whitelist' => 'nullable|array',
            'expires_at' => 'nullable|date|after:now',
        ];
    }
}