<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
{
    public function index()
    {
        return DB::table('products')
            ->select(
                'products.id AS product_id',
                'products.name AS product_name',
                'products.base_price AS base_price',
                'products.total_quantity AS total_quantity',
                'products.is_active AS is_active',
                'products.created_at AS created_at',
                DB::raw('JSON_ARRAYAGG(
                JSON_OBJECT(
                    "id", product_variations.id,
                    "variation_combination", product_variations.variation_combination,
                    "price", product_variations.price,
                    "quantity", product_variations.quantity
                )
            ) AS variations')
            )
            ->leftJoin('product_variations', 'products.id', '=', 'product_variations.product_id')
            ->groupBy('products.id');
    }

    public function store(array $data): Product
    {
        return Product::create($data);
    }
}
