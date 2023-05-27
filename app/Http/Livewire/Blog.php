<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class Blog extends Component
{
    public $creatingPost = false;
    public $posts;

    protected $listeners = ['close'];

    public function mount() {
        $this->posts = Post::all();
    }

    public function render()
    {
        return view('livewire.blog');
    }

    public function close() {
        $this->creatingPost = false;
    }
}
