<?php

namespace App\Repositories\Interfaces;

interface ProductVariationRepositoryInterface
{
    public function index(int $productId);

    public function store(array $productVariations);
}
