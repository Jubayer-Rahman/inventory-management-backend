<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface
{
    public function index();

    public function store(array $data);
}
