<?php

namespace App\Livewire;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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
        try {
            // Validate the incoming request
            $attributes = $this->validate($this->rules());

            if ($this->photo) {
                // Save the photo to a permanent location
                $attributes['profile_photo_path'] = $this->userService->upload($this->photo);
            }

            if($attributes['password'] == '') {
                unset($attributes['password']);
                unset($attributes['confirm_password']);
            }

            if ($this->userId) {
                // Update the existing user
                $this->userService->update($this->userId, $attributes);

                // If the authenticated user has their password updated, re-authenticate them
                if (Auth()->id() === $this->userId && isset($attributes['password'])) {
                    $user = $this->userService->find($this->userId);
                    // Re-authenticate the user
                    Auth()->login($user);
                }
            } else {
                // Create a new user
                $this->userService->store($attributes);
            }

            // Reset form fields to clear the form
            $this->reset();

            // Redirect to the user index route with a success message
            return redirect()->route('users.index')->with('success', 'User added/updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('scrollTop');
        }
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
