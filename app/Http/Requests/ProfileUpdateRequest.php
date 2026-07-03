<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            // Remove email validation since it's not in the form
            'is_online' => ['boolean'],
            'level' => ['required', 'integer', 'min:1', 'max:100'],
            'xp_points' => ['required', 'integer', 'min:0'],
            'kills_pvp' => ['required', 'integer', 'min:0'],
            'kills_pve' => ['required', 'integer', 'min:0'],
            'achievements_unlocked' => ['required', 'integer', 'min:0'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Username is required',
            'level.min' => 'Level must be at least 1',
            'level.max' => 'Level cannot exceed 100',
            '*.min' => 'Value cannot be negative',
            '*.integer' => 'Must be a whole number',
            '*.required' => 'This field is required',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Convert checkbox values to proper booleans
        $this->merge([
            'is_online' => filter_var($this->is_online, FILTER_VALIDATE_BOOLEAN),
        ]);
    }
}