<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserInvitationRequest;
use App\Models\UserInvitation;
use App\Repositories\Interfaces\UserInvitationRepositoryInterface;
use Illuminate\Http\Request;

class UserInvitationController extends Controller
{
    public function __construct(protected UserInvitationRepositoryInterface $userInvitationRepository) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return apiSuccessResponse('All user invitations retrieved', $this->userInvitationRepository->index($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserInvitationRequest $request)
    {
        $this->userInvitationRepository->store($request->validated());

        return apiSuccessResponse('User invitation created');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserInvitation $userInvitation)
    {
        $this->userInvitationRepository->destroy($userInvitation->id);
        return apiSuccessResponse('User Invitation deleted');
    }
}
