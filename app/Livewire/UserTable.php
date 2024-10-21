<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserTable extends Component
{
    public array $table;
    public array $pagination;
    public int $perPage = 20;
    public int $pageDelta = 2;
    public int $total;
    public int $totalPages;
    public int $currentPage = 1;
    public int $offset;
    public int $lastPage;
    public int $from;
    public int $to;
    public string $search = '';
    public string $sortField = 'id';
    public string $sortDirection = 'asc';
    public string $type = '';

    public function __construct()
    {
        // create table array
        $this->table = [
            'columns' => [
                'name' => 'Name',
                'username' => 'Username',
                'prefixname' => 'Prefix Name',
                'suffixname' => 'Suffix Name',
                'type' => 'Type',
                'actions' => 'Actions',
            ],
            'rows' => [],
        ];

        $this->setData();
        $this->setPagination();
    }

    public function nextPage() {
        $this->changePage($this->currentPage + 1);
    }

    public function previousPage() {
        $this->changePage($this->currentPage - 1);
    }

    public function changePage($page) {
        $this->currentPage = $page;
        $this->setData();
        $this->setPagination();
    }

    public function setData()
    {
        // get all the users except current logged-in user
        $users = User::where('deleted_at', null)
                    ->where('id', '!=', Auth::id())
                    ->get();

        // format the user collection data into a row array
        $rows = $this->formatData($users);

        // Calculate total number of rows
        $this->total = count($rows);

        // Calculate total number of pages
        $this->totalPages = ceil($this->total / $this->perPage);

        // Calculate the offset (index) to start slicing the array
        $offset = ($this->currentPage - 1) * $this->perPage;

        // Calculate the range of results
        $this->from = $offset + 1;
        $this->to = min($offset + $this->perPage, $this->total);

        // Slice the array to get items on the current page
        $pagedData = array_slice($rows, $offset, $this->perPage);

        // Set the pages data to the table
        $this->table['rows'] = $pagedData;
    }

    private function setPagination() {
        $pages = [];
        // Ensure current page is within total pages range
        if ($this->currentPage < 1 || $this->currentPage > $this->totalPages) {
            $this->from = 0;
            $this->pagination = [];
            return;
        }

        // Generate pagination numbers with delta for range
        $rangeStart = max(1, $this->currentPage - $this->pageDelta);
        $rangeEnd = min($this->totalPages, $this->currentPage + $this->pageDelta);

        //determine if first page is just before range start and add it
        if($rangeStart == 2) {
            $pages[] = 1;
        }

        // Ensure no negative or out-of-bounds values
        for ($i = $rangeStart; $i <= $rangeEnd; $i++) {
            $pages[] = $i;
        }

        //determine if last page is just after range end and add it
        if($rangeEnd + 1 == $this->totalPages) {
            $pages[] = $this->totalPages;
        }

        $this->pagination = [
            'pages' => $pages,
            'current_page' => $this->currentPage,
            'total_pages' => $this->totalPages,
            'jump_first' => $this->currentPage - $this->pageDelta > 2,
            'jump_last' => ($this->currentPage + $this->pageDelta) < ($this->totalPages - 1),
        ];


    }

    private function formatData($users) {
        $rows = array();

        // Loop through users and format row values to suit
        foreach ($users as $user) {
            $rows[] = [
                'id' => $user->id,
                'fullname' => $user->firstname . ' ' . $user->middlename . ' ' . $user->lastname,
                'prefixname' => $user->prefixname,
                'suffixname' => $user->suffixname,
                'username' => $user->name,
                'email' => $user->email,
                'photo' => $user->profile_photo_path,
                'type' => $user->type,
            ];
        }

        return $rows;
    }

    public function render()
    {
        return view('livewire.user-table');
    }
}
