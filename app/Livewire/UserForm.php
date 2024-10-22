<?php

namespace App\Livewire;

use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\UserServiceInterface;

class UserForm extends Component
{
    use WithFileUploads;

    public $userId;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $avatar;
    public $type = 'user';
    public $firstname = '';
    public $lastname = '';
    public $middlename = '';
    public $prefixname = 'Mr';
    public $suffixname = '';
    public $photo;

    public array $userTypes = [
        'admin',
        'user',
    ];
    public array $prefixNames = [
        'Mr',
        'Mrs',
        'Ms',
    ];

    protected $userService;

    public function mount(UserServiceInterface $userService, $id = null)
    {
        $this->userService = $userService;
        $this->userId = $id;

        if ($this->userId) {
            $user = $this->userService->find($this->userId);
            $this->name = $user->name;
            $this->email = $user->email;
            $this->type = $user->type;
            $this->avatar = $user->avatar;
            $this->firstname = $user->firstname;
            $this->lastname = $user->lastname;
            $this->middlename = $user->middlename;
            $this->prefixname = $user->prefixname;
            $this->suffixname = $user->suffixname;
        }
    }

    public function updatedPhoto()
    {
        if ($this->photo) {
            $this->avatar = $this->photo->temporaryUrl();
        }
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setPrefixName($prefixname)
    {
        $this->prefixname = $prefixname;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules());
    }

    public function rules()
    {
        return $this->userService->rules($this->userId);
    }

    public function store()
    {
        $attributes = $this->validate($this->rules());

        if ($this->photo) {
            // Save the photo to a permanent location
            $attributes['profile_photo_path'] = $this->userService->upload($this->photo);
        }

        if ($this->userId) {
            $this->userService->update($this->userId, $attributes);
            session()->flash('message', 'User successfully updated.');
        } else {
            $this->userService->store($attributes);
            session()->flash('message', 'User successfully created.');
        }

        $this->reset(); // Reset the form fields

        return redirect()->route('users.index')->with('success', 'User added/updated successfully!');
    }

    public function cancel()
    {
        return redirect()->route('users.index');
    }

    public function render()
    {
        return view('livewire.user-form');
    }

    public function hydrate()
    {
        // Reinstantiate the user service between calls
        $this->userService = App::make(UserServiceInterface::class);
    }
}
