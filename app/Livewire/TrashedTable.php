<?php

namespace App\Livewire;

use App\Services\UserServiceInterface;

class TrashedTable extends UserTable
{
    public function mount(UserServiceInterface $userService)
    {
        $this->userService = $userService;

        // create table array
        $this->columns = [
            'name' => 'Name',
            'username' => 'Username',
            'prefixname' => 'Prefix Name',
            'suffixname' => 'Suffix Name',
            'type' => 'Type',
            'actions' => 'Actions',
        ];

        $this->actions = [
            [
                'route' => 'users.restore',
                'hoverColor' => 'indigo-300',
                'icon' => 'fa-solid fa-rotate-left',
                'method' => 'PATCH',
            ],
            [
                'route' => 'users.delete',
                'hoverColor' => 'red-500',
                'icon' => 'fa-solid fa-ban',
                'method' => 'DELETE',
            ]
        ];
    }
    public function render()
    {
        $users = $this->userService->listTrashed($this->perPage);
        $rows = $users->items();
        $total = $this->userService->totalTrashed();

        return view('livewire.user-table', [
            'rows' => $this->formatData($rows),
            'pagination' => $this->getPagination($rows, $total),
        ]);
    }
}
