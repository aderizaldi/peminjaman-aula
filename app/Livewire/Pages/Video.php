<?php

namespace App\Livewire\Pages;

use App\Models\Setting;
use Livewire\Component;

class Video extends Component
{
    public $link;

    public function mount()
    {
        $this->link = Setting::where('key', 'video')->first()->value;
    }

    public function update()
    {
        $this->validate([
            'link' => 'required'
        ]);

        Setting::where('key', 'video')->update([
            'value' => $this->link
        ]);

        $this->dispatch('showToast', status: 'success', message: 'Data berhasil diubah.');
        $this->dispatch('videoUpdated');
    }

    public function render()
    {
        return view('livewire.pages.video');
    }
}
