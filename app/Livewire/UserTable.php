<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserTable extends Component
{
    public array $table;

    public function __construct()
    {
        $this->table = [
            'columns' => array(
                'name' => 'Name',
                'username' => 'Username',
                'prefixname' => 'Prefix Name',
                'suffixname' => 'Suffix Name',
                'type' => 'Type',
                'actions' => '',
            ),
            'rows' => array(),
        ];

        $this->populateRows();
    }

    public function populateRows() {
        // get all the users except current logged-in user
        $users = User::all()->except(Auth::id());
        // loop through users and format row values to suit
        foreach ($users as $user) {
            $this->table['rows'][] = [
                'id' => $user->id,
                'prefixname' => $user->prefixname,
                'firstname' => $user->firstname,
                'middlename' => $user->middlename,
                'lastname' => $user->lastname,
                'suffixname' => $user->suffixname,
                'username' => $user->name,
                'email' => $user->email,
                'photo' => $user->photo,
                'type' => $user->type,
            ];
        }
    }

    public function render()
    {
        return view('livewire.user-table');
    }
}
