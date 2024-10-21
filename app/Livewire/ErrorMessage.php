<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ErrorMessage extends Component
{
    public function clearErrors()
    {
        if (Session::has('error')) {
            Session::forget('error');
        }
    }

    public function render()
    {
        return view('livewire.error-message');
    }
}
