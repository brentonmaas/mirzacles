<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navbar extends Component
{
    public array $navMenu;
    public array $profileMenu;
    public string $currentNav;

    public function mount($nav)
    {
        $this->currentNav = $nav;

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
        return redirect()->route('users.edit',['userId'=> Auth::id()]);
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
