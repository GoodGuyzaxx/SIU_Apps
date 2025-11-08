<?php

namespace App\Livewire;

use App\Models\PapanInformasi;
use Livewire\Component;

class PapanInfoMobileSetting extends Component
{

    public $data = null;

    public string $yt_url = '';
    public string $running_text = '';


    public function render()
    {
        return view('livewire.papan-info-mobile-setting');
    }


    public function save(): void
    {
        PapanInformasi::query()->first()->update([
            'yt_url' => $this->yt_url ?: null,
            'running_text' => $this->running_text ?: null,
        ]);

        $this->dispatch('notify', message: '✅ Data tersimpan');
    }

    public function mount(){
        $data = PapanInformasi::find(1)->get()->first();

        if ($data) {
            $this->yt_url = $data->yt_url?? "";
            $this->running_text = $data->running_text ?? '';
        }
    }

}
