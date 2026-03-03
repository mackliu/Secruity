<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Route;

class Navbar extends Component
{
    public $currentRoute;

    public function mount()
    {
        $this->currentRoute = Route::currentRouteName();
    }

    public function render()
    {
        return view('livewire.navbar');
    }
}
