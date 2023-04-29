<?php

namespace App\Http\Livewire;

use Livewire\Component;

class RouteButton extends Component
{
    public $text;
    public $route;
    public $classes;
    public function redirectTo() {
        return redirect()->to($this->route);
    }

    public function mount(string $text, string $route, string $classes = '') {
        $this->text = $text;
        $this->route = $route;
        $this->classes = $classes;
    }

    public function render()
    {
        return view('livewire.route-button');
    }
}
