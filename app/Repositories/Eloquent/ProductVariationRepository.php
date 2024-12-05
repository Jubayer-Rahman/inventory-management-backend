<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\ProductVariationRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProductVariationRepository implements ProductVariationRepositoryInterface
{
    public function index(int $productId)
    {
        return DB::table('products')
            ->select(
                'products.id AS product_id',
                'products.name AS product_name',
                'products.description As product_description',
                'products.base_price AS base_price',
                'products.total_quantity AS total_quantity',
                'products.is_active AS is_active',
                DB::raw('JSON_ARRAYAGG(
                JSON_OBJECT(
                    "id", product_variations.id,
                    "variation_combination", product_variations.variation_combination,
                    "price", product_variations.price,
                    "quantity", product_variations.quantity,
                    "is_active", product_variations.is_active
                )
            ) AS variations')
            )
            ->where('products.id', '=', $productId)
            ->leftJoin('product_variations', 'products.id', '=', 'product_variations.product_id')
            ->groupBy('products.id')
            ->first();
    }

    public function store(array $productVariations)
    {
        DB::table('product_variations')->insert($productVariations);
    }
}
