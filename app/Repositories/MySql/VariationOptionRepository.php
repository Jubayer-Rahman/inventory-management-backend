<?php

namespace App\Repositories\MySql;

use App\Repositories\Interfaces\VariationOptionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VariationOptionRepository implements VariationOptionRepositoryInterface
{
    public function index()
    {
        $variations = DB::select("
            SELECT
                variations.id AS variation_id,
                variations.name AS variation_name,
                JSON_ARRAYAGG(variation_options.option) AS options
            FROM variations
            LEFT JOIN variation_options ON variations.id = variation_options.variation_id
            GROUP BY variations.id, variations.name
        ");

        if (!empty($variations)) {
            array_map(fn ($variation) => $variation->options = json_decode($variation->options), $variations);
        }

        return $variations;
    }

    public function show(int $variationId)
    {
        $variation = DB::select("
            SELECT
                variations.id AS variation_id,
                variations.name AS variation_name,
                JSON_ARRAYAGG(variation_options.option) AS options
            FROM variations
            LEFT JOIN variation_options ON variations.id = variation_options.variation_id
            WHERE variations.id = ?
            GROUP BY variations.id, variations.name
        ", [$variationId]);

        if (empty($variation)) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException('Variation with ID: '.$variationId.' not found!');
        }

        $variation[0]->options = json_decode($variation[0]->options);

        return $variation;
    }
}
