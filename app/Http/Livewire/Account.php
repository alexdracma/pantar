<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Account extends Component
{

    public $user;

    public function mount() {
        $this->user = Auth::user();
    }

    public function logout() {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        $this->redirect('/');
    }

    public function render()
    {
        return view('livewire.account');
    }
}
