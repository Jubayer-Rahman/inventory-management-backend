<?php

namespace App\Repositories\Interfaces;

use App\Models\Variation;

interface VariationRepositoryInterface
{
    public function index();

    public function store(array $data);

    public function update(array $data, Variation $variation);

    public function destroy(Variation $variation);
}
