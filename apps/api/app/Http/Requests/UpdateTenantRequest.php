<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class UpdateTenantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $tenant = $this->route('tenant');

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('tenants', 'slug')->ignore($tenant),
            ],
            'legal_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'logo_path' => ['nullable', 'string', 'max:500'],
            'timezone' => ['sometimes', 'required', 'string', 'max:100'],
            'currency' => ['sometimes', 'required', 'string', 'size:3'],
            'locale' => ['sometimes', 'required', 'string', 'max:10'],
            'status' => ['sometimes', Rule::in(['active', 'suspended'])],
            'settings' => ['nullable', 'array'],
        ];
    }
}
