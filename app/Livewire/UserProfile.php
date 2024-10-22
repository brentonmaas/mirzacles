<?php

namespace App\Livewire;

use App\Services\UserServiceInterface;
use Livewire\Component;
use App\Models\User;

class UserProfile extends Component
{
    public $user;
    public string $fullname;

    protected $userService;

    public function mount(UserServiceInterface $userService, $id)
    {
        // Retrieve the user by ID
        $this->userService = $userService;
        $this->user = $this->userService->find($id);

        // Handle the case where the user might not be found
        if (!$this->user) {
            return redirect()->route('users.index')->with('error', 'User not found!');
        }

        $this->fullname = $this->user->getFullnameAttribute();
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
