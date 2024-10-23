<?php

namespace App\Listeners;

use App\Events\UserSaved;
use App\Services\UserService;

class SaveUserBackgroundInformation
{
    protected $userService;

    /**
     * Create the event listener.
     *
     * @param UserService $userService
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle the event.
     *
     * @param UserSaved $event
     * @return void
     */
    public function handle(UserSaved $event)
    {
        $this->userService->updateDetails($event->user);
    }
}
