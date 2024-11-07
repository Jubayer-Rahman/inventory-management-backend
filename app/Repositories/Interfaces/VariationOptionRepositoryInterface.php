<?php

namespace App\Repositories\Interfaces;

interface VariationOptionRepositoryInterface
{
    public function index(int $variationId);

    public function store(array $options);

    public function update(array $options);

    public function destroy(array $optionIds);
}
