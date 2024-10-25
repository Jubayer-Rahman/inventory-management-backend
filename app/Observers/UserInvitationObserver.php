<?php

namespace App\Observers;

use App\Models\UserInvitation;

class UserInvitationObserver
{
    /**
     * Handle the UserInvitation "creating" event.
     *
     * @param UserInvitation $userInvitation
     * @return void
     */
    public function creating(UserInvitation $userInvitation): void
    {
        $userInvitation->token = str()->random(30);
        $userInvitation->expires_at = now()->addHours(3);
    }


    /**
     * Handle the UserInvitation "created" event.
     */
    public function created(UserInvitation $userInvitation): void
    {
        //
    }
}
