<?php

namespace App\Services;

use App\Models\Variation;
use App\Models\VariationOption;
use App\Repositories\Interfaces\VariationOptionRepositoryInterface;
use App\Repositories\Interfaces\VariationRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class VariationOptionService
{
    public function __construct(
        private VariationOptionRepositoryInterface $variationOptionRepository,
        private VariationRepositoryInterface $variationRepository,
        private VariationOption $variationOption
    ) {}

    public function index(Request $request, int $variationId)
    {
        $variationOptions = $this->variationOptionRepository->index($variationId);

        $variationOptions->options = json_decode($variationOptions->options);

        return $variationOptions;
    }

    public function store(int $variationId, array $options): void
    {
        $this->variationOptionRepository->store($this->transformOptionsForStore($options, $variationId));
    }

    public function update(Variation $variation, array $validatedRequest): void
    {
        DB::beginTransaction();

        try{
            if (!empty($validatedRequest['name'])) {
                $variation->update(Arr::only($validatedRequest, $variation->getFillable()));
            }

            $this->variationOptionRepository->update($this->transformOptionsForUpdate($validatedRequest['options'], $variation->id));
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function destroy(Variation $variation, array $optionIds)
    {
        if ($variation->options()->count() == count($optionIds)) {
            throw new \Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException('Cannot delete all options. At least one option must remain.');
        }

        $this->variationOptionRepository->destroy($optionIds);
    }

    private function transformOptionsForStore(array $options, int $variationId): array
    {
        $timestamp = now();
        return array_map(fn($option) => [
            'option' => ucwords($option),
            'variation_id' => $variationId,
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ], $options);
    }

    private function transformOptionsForUpdate(array $options, int $variationId): array
    {
        return array_map(fn($option) => [
            'id' => $option['id'],
            'option' => ucwords($option['option']),
            'variation_id' => $variationId,
            'updated_at' => now()
        ], $options);
    }
}
