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
            'user' => 'User',
            'fullname' => 'Fullname',
            'middle' => 'Middle Initial',
            'gender' => 'Gender',
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
                'route' => 'users.destroy',
                'hoverColor' => 'red-500',
                'icon' => 'fa-solid fa-burst',
                'method' => 'GET',
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
