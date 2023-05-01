<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Sidebar extends Component
{
    public function changeMain(string $componentName) {
        $this->emitUp('changeMain', $componentName);
    }
    public function render()
    {
        return view('livewire.sidebar');
    }
}
