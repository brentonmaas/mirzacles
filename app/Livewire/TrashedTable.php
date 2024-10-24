<?php

namespace App\Livewire;

use App\Services\UserServiceInterface;

class TrashedTable extends UserTable
{
    public function mount(UserServiceInterface $userService)
    {
        $this->userService = $userService;
        $this->addUser = false;

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
                'dialog' => false,
            ],
            [
                'route' => 'users.destroy',
                'hoverColor' => 'red-500',
                'icon' => 'fa-solid fa-burst',
                'method' => 'GET',
                'dialog' => true,
            ]
        ];

        $this->modal = [
            'show' => false,
            'route' => '',
            'userId' => '',
            'method' => '',
            'title' => 'Destroy User',
            'text' => 'Are you sure you want to permanently?',
            'button' => 'Destroy',
        ];
    }

    public function showModal($route, $userId, $method)
    {
        $this->modal = [
            'show' => true,
            'route' => $route,
            'userId' => $userId,
            'method' => $method,
            'title' => $this->modal['title'],
            'text' => $this->modal['text'],
            'button' => $this->modal['button'],
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
