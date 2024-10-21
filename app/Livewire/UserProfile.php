<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class UserProfile extends Component
{
    public $user;
    public string $fullname;
    public string $imageIsUrl;

    public function mount($id)
    {
        // Retrieve the user by ID
        $this->user = User::find($id);

        // Handle the case where the user might not be found
        if (!$this->user) {
            return redirect()->route('users.index')->with('error', 'User not found!');
        }

        $this->fullname = $this->user->firstname . ' ' . $this->user->middlename . ' ' . $this->user->lastname;

        if ($this->startsWithHttpOrHttps($this->user->profile_photo_path)) {
            $this->imageIsUrl = true;
        } else {
            $this->imageIsUrl = false;
        }
    }

    function startsWithHttpOrHttps($url) {
        return (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0);
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
