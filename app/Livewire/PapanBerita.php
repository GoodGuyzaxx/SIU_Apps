<?php

namespace App\Livewire;

use App\Models\Gallery;
use App\Models\Player;
use App\Models\Post;
use Livewire\Component;

class PapanBerita extends Component
{
    public $galleries;
    public $post;
    public $player;

    public function mount(): void
    {
        $this->galleries = Gallery::latest()->get();
        $this->post = Post::latest()->first();
        $this->player = Player::latest()->first();
    }

    public function render()
    {
        return view('livewire.papan-berita');
    }
}
