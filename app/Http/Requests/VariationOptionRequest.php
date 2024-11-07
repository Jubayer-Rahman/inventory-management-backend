<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VariationOptionRequest extends FormRequest
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

        if ($this->isMethod('delete')) {
            return $this->destroyRules();
        }

        return [
            'options' => 'required|array',
            'options.*' => 'string|max:32|distinct|unique:variation_options,option',
        ];
    }

    public function messages()
    {
        return [
            'options.*.string' => 'Variation options should be string.',
            'options.*.max' => 'Variation options must not be greater than :max characters.',
            'options.*.distinct' => 'Duplicate values are not allowed for variation options.',
            'options.*.unique' => 'Variation option already been taken.',
        ];
    }

    private function updateRules(): array
    {
        $variationId = $this->route('variation');
        return [
            'name' => 'string|max:32|unique:variations,name',
            'options' => 'array',
            'options.*.id' => [
                'required_with:options',
                'distinct',
                Rule::exists('variation_options', 'id')->where('variation_id', $variationId),
            ],
            'options.*.option' => [
                'required_with:options',
                'string',
                'max:32',
                'distinct',
                Rule::unique('variation_options', 'option')
                ->where('variation_id', $variationId),
            ]
        ];
    }

    private function destroyRules(): array
    {
        $variationId = $this->route('variation');
        return [
            'options' => 'required|array',
            'options.*' => [
                'distinct',
                Rule::exists('variation_options', 'id')->where('variation_id', $variationId),
            ]
        ];
    }
}
