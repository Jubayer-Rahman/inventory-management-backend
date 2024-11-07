<?php

namespace App\Repositories\Eloquent;

use App\Models\Variation;
use App\Repositories\Interfaces\VariationRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class VariationRepository implements VariationRepositoryInterface
{
    public function __construct(private Variation $variation) {}

    public function index()
    {
        return DB::table('variations')
        ->select(
            'variations.id AS variation_id',
            'variations.name AS variation_name',
            DB::raw('JSON_ARRAYAGG(
                JSON_OBJECT("id", variation_options.id, "option", variation_options.option)
            ) AS options')
        )
        ->leftJoin('variation_options', 'variations.id', '=', 'variation_options.variation_id')
        ->groupBy('variations.id', 'variations.name');
    }

    public function store(array $data)
    {
        return $this->variation->create($data);
    }

    public function update(array $data, Variation $variation)
    {
        $variation->update(Arr::only($data, $this->variation->getFillable()));
    }

    public function destroy(Variation $variation)
    {
        $variation->delete();
    }
}
