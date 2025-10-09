<?php

namespace App\Livewire\Pages;

use App\Models\Time;
use Livewire\Component;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class HallReservation extends Component
{
    use WithPagination, WithoutUrlPagination;

    public Schedule $schedule;

    public $search = null;
    public $per_page = 10;

    public $modal = [
        'detail' => false
    ];

    public function openModal($modal, $id = null)
    {
        if ($modal == 'detail' && $id) {
            $this->schedule = Schedule::find($id);
        }

        $this->modal[$modal] = true;
    }

    public function closeModal($modal)
    {
        $this->modal[$modal] = false;
    }

    public function getSchedules()
    {
        $query = Schedule::query();

        if (Auth::user()->hasRole('user')) {
            $query->where('user_id', Auth::user()->id);
        }

        if ($this->search) {
            $query->where('event_name', 'like', '%' . $this->search . '%')->orWhere('description', 'like', '%' . $this->search . '%')->orWhere('status', 'like', '%' . $this->search . '%')->orWhere('halls.name', 'like', '%' . $this->search . '%')->orWhere('responsible_person', 'like', '%' . $this->search . '%');
        }

        $query->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')");

        return $query->paginate($this->per_page);
    }

    public function render()
    {
        return view('livewire.pages.hall-reservation', [
            'schedules' => $this->getSchedules(),
        ]);
    }
}
