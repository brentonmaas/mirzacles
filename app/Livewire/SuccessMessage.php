<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class SuccessMessage extends Component
{
    public function clearSuccess()
    {
        if (Session::has('success')) {
            Session::forget('success');
        }
    }

    public function render()
    {
        return view('livewire.success-message');
    }
}
