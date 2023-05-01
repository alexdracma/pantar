<?php

namespace App\Http\Livewire;

use Livewire\Component;

class App extends Component
{
    private $component = '';
    protected $listeners = ['changeMain' => 'loadComponent'];
    public function loadComponent(string $componentName) {
        $this->component = $componentName;
    }

    public function mount(string $component = 'account') {
        $this->component = $component;
    }

    public function render()
    {
        return view('livewire.app', [
            'component' => $this->component,
            // key is required to force a refresh of the container component
            'key' => random_int(-999, 999),
        ])->layout('layouts.master');
    }
}
