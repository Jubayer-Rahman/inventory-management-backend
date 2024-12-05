<?php

namespace App\Http\Requests;

use App\Models\VariationOption;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ProductRequest extends FormRequest
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
            'name' => 'required|string|max:64|unique:products',
            'description' => 'string|max:2048',
            'base_price' => 'required|decimal:0,2|min:0',
            'total_quantity' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'variations' => 'array|min:1',
            'variations.*' => 'required_with:variations',
            'variations.*.variation_combination' => 'required_with:variations.*|string|max:64|distinct',
            'variations.*.price' => 'required_with:variations.*|decimal:0,2|min:0',
            'variations.*.quantity' => 'required_with:variations.*|integer|min:0',
            'product_options' => 'required_with:variations|array',
            'product_options.*' => 'exists:variation_options,id'
        ];
    }

    public function messages()
    {
        return [
            'variations.*.required_with' => 'At least one :attribute is required when variations are present.'
        ];
    }

    public function attributes()
    {
        return [
            'variations.*' => 'variation',
            'variations.*.variation_combination' => 'variation combination',
            'variations.*.price' => 'variation price',
            'variations.*.quantity' => 'variation quantity',
        ];
    }

    public function validateTotalQuantityMatchesVariationsQuantity(): void
    {
        $variations = $this->input('variations', []);

        if (empty($variations)) {
            return;
        }

        $variationsQuantityTotal = array_sum(array_column($variations, 'quantity'));

        if ($variationsQuantityTotal !== (int) $this->input('total_quantity')) {
            throw ValidationException::withMessages([
                'total_quantity' => 'The total quantity must match the sum of variation quantities.',
            ]);
        }
    }

    public function validateVariationCombinations(): void
    {
        $variations = $this->input('variations', []);
        $productOptionsIds = collect($this->input('product_options', []));

        if (empty($variations)) {
            return;
        }

        $validOptions = VariationOption::pluck('id', 'option')->toArray();
        $allMatchingOptionIds = [];

        foreach ($variations as $index => $variation) {
            $parts = array_unique(explode('-', $variation['variation_combination']));
            $invalidParts = array_diff($parts, array_keys($validOptions));

            if ($invalidParts) {
                throw ValidationException::withMessages([
                    "variations.{$index}.variation_combination" => "The part(s) '" . implode(', ', $invalidParts) . "' are not valid options in the variation options.",
                ]);
            }

            $allMatchingOptionIds = array_merge($allMatchingOptionIds, array_values(array_intersect_key($validOptions, array_flip($parts))));
        }

        $distinctMatchingOptionIds = array_unique($allMatchingOptionIds);

        if ($productOptionsIds->intersect($distinctMatchingOptionIds)->count() !== count($distinctMatchingOptionIds)) {
            throw ValidationException::withMessages([
                "product_options" => "The selected product options don't match the variation combination.",
            ]);
        }
    }

    public function withValidator($validator)
    {
        $validator->after(function () {
            $this->validateTotalQuantityMatchesVariationsQuantity();
            $this->validateVariationCombinations();
        });
    }
}
