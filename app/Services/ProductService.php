<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ProductService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private Product $product,
        private ProductVariationService $productVariationService
    ) {}

    public function index()
    {
        return $this->productRepository->index()
            ->get()
            ->map(function ($product) {
                $product->variations = json_decode($product->variations);
                return $product;
            });
    }

    public function store(array $validatedData): void
    {
        DB::beginTransaction();

        try {
            $product = $this->productRepository->store(Arr::only($validatedData, $this->product->getFillable()));

            if(!empty($validatedData['variations'])) {
                $this->productVariationService->store($product->id, $validatedData['variations']);

                $product->variationOptions()->attach($validatedData['product_options']);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
}
