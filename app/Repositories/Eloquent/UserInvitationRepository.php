<?php

namespace App\Repositories\Eloquent;

use App\Models\UserInvitation;
use App\Repositories\Interfaces\UserInvitationRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UserInvitationRepository implements UserInvitationRepositoryInterface
{
    public function index(Request $request): Collection
    {
        return UserInvitation::get();
    }

    public function store(array $data)
    {
        UserInvitation::create($data);
    }

    public function destroy(int $id)
    {
        UserInvitation::destroy($id);
    }
}
