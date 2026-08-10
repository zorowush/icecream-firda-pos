<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

            'current_password' => [
                'nullable',
                'required_with:password',
                function ($attribute, $value, $fail) {
                    if ($this->filled('password')) {
                        if (! Hash::check($value, $this->user()->password)) {
                            $fail('Password lama tidak sesuai.');
                        }
                    }
                },
            ],

            'password' => [
                'nullable',
                'confirmed',
                'min:8',
                'required_with:current_password',
            ],
        ];
    }
}
