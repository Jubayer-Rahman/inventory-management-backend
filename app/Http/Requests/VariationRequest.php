<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VariationRequest extends FormRequest
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
            'name' => 'required|string|max:32|unique:variations,name',
            'options' => 'required|array',
            'options.*' => 'string|max:32|distinct',
        ];
    }

    public function messages()
    {
        return [
            'options.*.string' => 'Variation options should be string.',
            'options.*.max' => 'Variation options can be at most :max characters.',
            'options.*.distinct' => 'Duplicate values are not allowed for variation options.',
        ];
    }
}
