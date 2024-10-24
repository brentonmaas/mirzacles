<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class ModalDialog extends Component
{
    public bool $show = false;
    public string $route = '';
    public string $userId = '';
    public string $method = '';
    public string $title = '';
    public string $text = '';
    public string $button = '';

    public function showModal()
    {
        $this->show = true;
    }

    public function closeModal()
    {
        $this->show = false;
    }
    public function render()
    {
        return view('livewire.modal-dialog');
    }
}
