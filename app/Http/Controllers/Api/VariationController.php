<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VariationRequest;
use App\Models\Variation;
use App\Repositories\Interfaces\VariationRepositoryInterface;
use App\services\VariationService;
use Illuminate\Http\Request;

class VariationController extends Controller
{
    public function __construct(private VariationService $variationService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return apiSuccessResponse('Variations retrieved', $this->variationService->index($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VariationRequest $request)
    {
        return apiSuccessResponse('Variation created', $this->variationService->store($request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Variation $variation, VariationRepositoryInterface $variationRepository)
    {
        return apiSuccessResponse('Variation deleted', $variationRepository->destroy($variation));
    }
}
