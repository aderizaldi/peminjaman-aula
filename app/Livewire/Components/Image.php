<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Image as ModelsImage;

class Image extends Component
{
    public $images;

    public $currentIndex = 0;

    public function mount()
    {
        $this->images = ModelsImage::all()->pluck('image')->toArray();
    }

    public function nextImage()
    {
        $this->currentIndex = ($this->currentIndex + 1) % count($this->images);
    }

    public function updateImage()
    {
        $this->images = ModelsImage::all()->pluck('image')->toArray();
    }

    public function render()
    {
        return view('livewire.components.image');
    }
}
