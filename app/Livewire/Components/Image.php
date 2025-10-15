<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Image extends Component
{
    public $images = [
        'https://images.pexels.com/photos/12719297/pexels-photo-12719297.jpeg',
        'https://images.pexels.com/photos/12719260/pexels-photo-12719260.jpeg',
        'https://images.pexels.com/photos/13389844/pexels-photo-13389844.jpeg',
        "https://images.pexels.com/photos/9350186/pexels-photo-9350186.jpeg",
    ];

    public $currentIndex = 0;

    public function nextImage()
    {
        $this->currentIndex = ($this->currentIndex + 1) % count($this->images);
    }
    public function render()
    {
        return view('livewire.components.image');
    }
}
