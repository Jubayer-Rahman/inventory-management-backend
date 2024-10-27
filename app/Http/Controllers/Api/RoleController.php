<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //public function __construct(protected RoleRepositoryInterface $roleRepository) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, RoleRepositoryInterface $roleRepository)
    {
        return apiSuccessResponse('Roles retrieved', $roleRepository->index($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
