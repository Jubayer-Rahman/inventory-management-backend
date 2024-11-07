<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VariationOptionRequest;
use App\Models\Variation;
use App\Services\VariationOptionService;
use Illuminate\Http\Request;

class VariationOptionController extends Controller
{
    public function __construct(private VariationOptionService $variationOptionService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Variation $variation)
    {
        return apiSuccessResponse('Retrieved variation with options', $this->variationOptionService->index($request, $variation->id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VariationOptionRequest $request, Variation $variation)
    {
        return apiSuccessResponse('Created variations with options', $this->variationOptionService->store($variation->id, $request->options));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VariationOptionRequest $request, Variation $variation)
    {
        return apiSuccessResponse('Updated variation options', $this->variationOptionService->update($variation, $request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VariationOptionRequest $request, Variation $variation)
    {
        return apiSuccessResponse('Deleted variation options', $this->variationOptionService->destroy($variation, $request->validated()['options']));
    }
}
