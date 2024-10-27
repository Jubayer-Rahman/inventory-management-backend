<?php

namespace App\Repositories\Interfaces;

use App\Models\UserInvitation;
use Illuminate\Http\Request;

interface UserInvitationRepositoryInterface
{
    public function index(Request $request);
    public function store(array $data);
    public function destroy(int $id);
}
