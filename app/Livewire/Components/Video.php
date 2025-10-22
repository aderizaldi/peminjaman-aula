<?php

namespace App\Livewire\Components;

use App\Models\Setting;
use Livewire\Component;

class Video extends Component
{
    public $link;
    public $video_id = '';

    public function mount()
    {
        $this->link = Setting::where('key', 'video')->first()->value;
        $this->video_id = $this->getVideoIdAttribute();
    }

    public function updateVideo()
    {
        $this->link = Setting::where('key', 'video')->first()->value;
        $this->video_id = $this->getVideoIdAttribute();
    }

    public function getVideoIdAttribute()
    {
        $url = "https://www.youtube.com/embed/RbvaLbX1JVg?si=YhfRCvVUan1IOuDs";
        $id = "";
        $pattern = '/embed\/([a-zA-Z0-9_-]+)/'; // Pola untuk menangkap ID setelah 'embed/'

        // Jalankan pencarian pola. Hasil tangkapan (ID video) akan disimpan di $matches[1]
        if (preg_match($pattern, $url, $matches)) {
            // ID video ada pada indeks 1 dari array $matches
            $id = $matches[1];
        }

        return $id;
    }

    public function render()
    {
        return view('livewire.components.video');
    }
}
