<?php

namespace App\services;

use App\Models\Variation;
use App\Models\VariationOption;
use App\Repositories\Interfaces\VariationRepositoryInterface;
use App\Services\VariationOptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class VariationService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private VariationRepositoryInterface $variationRepository,
        private VariationOptionService $variationOptionService,
        private Variation $variation,
    ) {}

    public function index(Request $request)
    {
        return $this->variationRepository->index()
            ->get()
            ->map(function ($variation) {
                $variation->options = json_decode($variation->options);
                return $variation;
            });
    }

    public function store(array $validatedRequest): void
    {
        DB::beginTransaction();

        try {
            $variation = $this->variationRepository->store(Arr::only($validatedRequest, $this->variation->getFillable()));

            $this->variationOptionService->store($variation->id, $validatedRequest['options']);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
}
