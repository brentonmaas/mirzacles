<?php

namespace App\Livewire;

use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navbar extends Component
{
    public array $navMenu;
    public array $profileMenu;
    public string $profileImage;
    public string $currentNav;
    protected $userService;

    public function mount($nav, UserService $userService)
    {
        $this->currentNav = $nav;
        $this->userService = $userService;

        $user = $this->userService->find(Auth::id());
        $this->profileImage = $user->avatar;

        $this->navMenu = [
            [
                'label' => 'Users',
                'handler' => 'viewUsers',
            ],
            [
                'label' => 'Trashed',
                'handler' => 'viewTrashed',
            ]
        ];

        $this->profileMenu = [
            [
                'label' => 'Your Profile',
                'handler' => 'editProfile',
            ],
            [
                'label' => 'Sign Out',
                'handler' => 'logout',
            ]
        ];
    }

    public function viewUsers()
    {
        return redirect()->route('users.index');
    }

    public function editProfile()
    {
        return redirect()->route('users.edit',['id'=> Auth::id()]);
    }

    public function viewTrashed()
    {
        return redirect()->route('users.trashed');
    }

    public function logout()
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        return redirect('/login');
    }

    public function highlight()
    {
        $this->dispatch('highlightElement');
    }

    public function unhighlight()
    {
        $this->dispatch('unhighlightElement');
    }

    public function render()
    {
        return view('livewire.navbar');
    }
}
