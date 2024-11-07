<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\VariationOptionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class VariationOptionRepository implements VariationOptionRepositoryInterface
{
    public function index(int $variationId)
    {
        return DB::table('variations')
            ->select(
                'variations.id AS variation_id',
                'variations.name AS variation_name',
                DB::raw('JSON_ARRAYAGG(
                    JSON_OBJECT("id", variation_options.id, "option", variation_options.option)
                ) AS options')
            )
            ->where('variations.id', '=', $variationId)
            ->leftJoin('variation_options', 'variations.id', '=', 'variation_options.variation_id')
            ->groupBy('variations.id', 'variations.name')
            ->first();
    }

    public function store(array $options)
    {
        DB::table('variation_options')->insert($options);
    }

    public function update(array $options)
    {
        DB::table('variation_options')->upsert($options, ['id'], ['option']);
    }

    public function destroy(array $optionIds)
    {
        DB::table('variation_options')->whereIn('id', $optionIds)->delete();
    }
}
