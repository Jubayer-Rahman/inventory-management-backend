<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductVariationService;
use Illuminate\Http\Request;

class ProductVariationController extends Controller
{
    public function __construct(private ProductVariationService $productVariationService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Product $product)
    {
        return apiSuccessResponse('Retrieved product with variations', $this->productVariationService->index($request, $product));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
