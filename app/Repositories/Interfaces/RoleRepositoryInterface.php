<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface RoleRepositoryInterface
{
    public function index(Request $request);
}
