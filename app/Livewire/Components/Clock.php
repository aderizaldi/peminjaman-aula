<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Clock extends Component
{
    public $currentTime;
    public $currentDate;

    public function mount()
    {
        $this->currentTime = now()->format('H:i:s');
        $this->currentDate = now()->format('l, d F Y');
    }

    public function updateTime()
    {
        $this->currentTime = now()->format('H:i:s');
    }

    public function updateDate()
    {
        $this->currentDate = now()->format('l, d F Y');
    }

    public function render()
    {
        return view('livewire.components.clock');
    }
}
