<?php

namespace App\Livewire\Components;

use Livewire\Component;

class ToastNotification extends Component
{
    public $message = '';
    public $type = 'success';

    protected $listeners = ['showToast'];

    public function showToast($status, $message)
    {
        $this->dispatch('show-toast', [
            'status' => $status,
            'message' => $message
        ]);
    }

    public function render()
    {
        return view('livewire.components.toast-notification');
    }
}
