<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class RegisterUserRequest extends FormRequest
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
        return [
            'name' => 'required|alpha|max:64',
            'email' => 'required|email|max:254|unique:users',
            'password' => 'required|min:5|confirmed',
        ];
    }

    protected function passedValidation()
    {
        $this->merge([
            'name' => Str::title($this->name),
            // 'password' => Hash::make($this->password)
        ]);
    }
}
