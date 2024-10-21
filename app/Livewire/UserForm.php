<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserForm extends Component
{
    use WithFileUploads;

    public $user;
    public $photo;
    public array $userTypes;
    public array $prefixNames;

    public function mount($id)
    {
        // Retrieve the user by ID
        $this->user = User::find($id)->toArray();

        // Handle the case where the user might not be found
        if (!$this->user) {
            return redirect()->route('users.index')->with('error', 'User not found!');
        }

        // Set user types
        $this->userTypes = [
            'admin',
            'user',
        ];

        // Set prefix names
        $this->prefixNames = [
            'Mr',
            'Mrs',
            'Ms',
        ];
    }

    public function setType($type)
    {
        $this->user['type'] = $type;
    }

    public function setPrefixName($prefixname)
    {
        $this->user['prefixname'] = $prefixname;
    }

    public function render()
    {
        return view('livewire.user-form');
    }
}
