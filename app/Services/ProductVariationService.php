<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariation;
use App\Repositories\Interfaces\ProductVariationRepositoryInterface;
use Illuminate\Http\Request;

class ProductVariationService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private ProductVariationRepositoryInterface $productVariationRepository,
        private ProductVariation $productVariation
    ) {}

    public function index(Request $request, Product $product)
    {
        $productVariations = $this->productVariationRepository->index($product->id);

        $productVariations->variations = json_decode($productVariations->variations);

        return $productVariations;
    }

    public function store(int $productId, array $productVariations): void
    {
        $this->productVariationRepository->store($this->transformProductVariationsForStore($productVariations, $productId));
    }

    private function transformProductVariationsForStore(array $productVariations, int $productId): array
    {
        $timestamp = now();
        return array_map(fn($productVariation) => [
            'product_id' => $productId,
            'variation_combination' => $productVariation['variation_combination'],
            'price' => $productVariation['price'],
            'quantity' => $productVariation['quantity'],
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ], $productVariations);
    }
}
