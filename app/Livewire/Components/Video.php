<?php

namespace App\Livewire\Components;

use App\Models\Setting;
use Livewire\Component;

class Video extends Component
{
    public $link;

    public function mount()
    {
        $this->link = Setting::where('key', 'video')->first()->value;
    }

    public function updateVideo()
    {
        $this->link = Setting::where('key', 'video')->first()->value;
    }

    public function render()
    {
        return view('livewire.components.video');
    }
}
