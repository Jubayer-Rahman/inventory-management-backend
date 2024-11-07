<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            return $this->updateRules();
        }

        return [
            'name' => 'required|regex:/^[A-Za-z\s]+$/|max:64',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:5|confirmed',
        ];
    }

    private function updateRules(): array
    {
        return [
            'name' => 'regex:/^[A-Za-z\s]+$/|max:64',
            'email' => 'prohibited',
            'current_password' => 'string|required_with:new_password',
            'new_password' => 'string|required_with:current_password|min:5|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'email.prohibited' => 'Email can not be changed',
            'current_password.required_with' => 'Old password field should present',
            'new_password.required_with' => 'New password field should present',
        ];
    }

    /**
     * Attempt to verify the existing password.
     *
     * @throws ValidationException
     */
    public function verifyPassword(string $existingPassword)
    {
        if ($this->filled('current_password') && ! Hash::check($this->current_password, $existingPassword)) {
            throw ValidationException::withMessages(['current_password' => 'Wrong current password']);
        }
    }
}
