<?php

namespace App\Livewire;

use App\Models\User;
use App\Services\UserServiceInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination;
    public int $perPage = 20;
    public int $pageDelta = 2;
    public int $currentPage = 1;

    public array $columns;
    public array $actions;

    protected $userService;

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
                'route' => 'users.show',
                'hoverColor' => 'indigo-300',
                'icon' => 'fa-solid fa-eye',
                'method' => 'GET',
            ],
            [
                'route' => 'users.edit',
                'hoverColor' => 'indigo-300',
                'icon' => 'fa-solid fa-pen-to-square',
                'method' => 'GET',
            ],
            [
                'route' => 'users.delete',
                'hoverColor' => 'red-500',
                'icon' => 'fa-solid fa-trash-can',
                'method' => 'DELETE',
            ]
        ];
    }

    public function nextPage() {
        $this->currentPage++;
        $this->setPage($this->currentPage);
    }

    public function previousPage() {
        $this->currentPage--;
        $this->setPage($this->currentPage);
    }

    public function changePage($page) {
        $this->currentPage = $page;
        $this->setPage($page);
    }

    protected function formatData($users)
    {
        $rows = array();

        // Loop through users and format row values to suit
        foreach ($users as $user) {
            $rows[] = [
                'id' => $user->id,
                'user' => $user->name,
                'fullname' => $user->fullname,
                'middle' => $user->middleInitial,
                'gender' => $user->gender,
                'email' => $user->email,
                'photo' => $user->avatar,
                'type' => $user->type,
            ];
        }

        return $rows;
    }

    protected function getPagination($rows, $total) {
        $pages = [];

        // Calculate total number of pages
        $totalPages = ceil($total / $this->perPage);

        // Calculate the offset (index) to start slicing the array
        $offset = ($this->currentPage - 1) * $this->perPage;

        // Calculate the range of results
        $from = $offset + 1;
        $to = min($offset + $this->perPage, $total);

        // Ensure current page is within total pages range
        if ($this->currentPage < 1 || $this->currentPage > $totalPages) {
            $from = 0;
        }

        // Generate pagination numbers with delta for range
        $rangeStart = max(1, $this->currentPage - $this->pageDelta);
        $rangeEnd = min($totalPages, $this->currentPage + $this->pageDelta);

        // Determine if first page is just before range start and add it
        if($rangeStart == 2) {
            $pages[] = 1;
        }

        // Ensure no negative or out-of-bounds values
        for ($i = $rangeStart; $i <= $rangeEnd; $i++) {
            $pages[] = $i;
        }

        // Determine if last page is just after range end and add it
        if($rangeEnd + 1 == $totalPages) {
            $pages[] = $totalPages;
        }

        return array(
            'total' => $total,
            'pages' => $pages,
            'current_page' => $this->currentPage,
            'total_pages' => $totalPages,
            'from' => $from,
            'to' => $to,
            'jump_first' => $this->currentPage - $this->pageDelta > 2,
            'jump_last' => ($this->currentPage + $this->pageDelta) < ($totalPages - 1),
        );
    }

    public function createUser()
    {
        return redirect()->route('users.create');
    }

    public function render()
    {
        $users = $this->userService->list($this->perPage);
        $rows = $users->items();
        $total = $this->userService->total();

        return view('livewire.user-table', [
            'rows' => $this->formatData($rows),
            'pagination' => $this->getPagination($rows, $total),
        ]);
    }

    public function hydrate()
    {
        // Reinstantiate the user service between calls
        $this->userService = App::make(UserServiceInterface::class);
    }
}
