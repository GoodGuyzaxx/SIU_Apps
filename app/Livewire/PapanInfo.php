<?php

namespace App\Livewire;

use App\Models\PapanInformasi;
use Livewire\Component;

class PapanInfo extends Component
{
    public $data = null;

    public function render()
    {
        return view('livewire.papan-info');
    }

    public function mount(){
        $this->data = PapanInformasi::find(1)->get();
    }
}
