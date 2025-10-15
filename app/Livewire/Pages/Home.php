<?php

namespace App\Livewire\Pages;

use App\Models\Hall;
use App\Models\Time;
use Livewire\Component;
use App\Enums\ScheduleStatus;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.main')]
class Home extends Component
{
    public $halls;
    public $selected_hall;
    public $times;

    public function mount()
    {
        $this->halls = Hall::all();
        $this->selected_hall = Hall::first();
        $this->times = Time::where('date', now()->format('Y-m-d'))->whereRelation('schedule', 'status', ScheduleStatus::APPROVED)->whereRelation('schedule', 'hall_id', $this->selected_hall->id)->orderBy('start_time')->get();
    }

    public function selectHall($id)
    {
        $this->selected_hall = Hall::find($id);
        $this->times = Time::where('date', now()->format('Y-m-d'))->whereRelation('schedule', 'status', ScheduleStatus::APPROVED)->whereRelation('schedule', 'hall_id', $this->selected_hall->id)->orderBy('start_time')->get();
    }

    public function updateTimes()
    {
        $this->times = Time::where('date', now()->format('Y-m-d'))->whereRelation('schedule', 'status', ScheduleStatus::APPROVED)->whereRelation('schedule', 'hall_id', $this->selected_hall->id)->orderBy('start_time')->get();
    }

    public function render()
    {
        return view('livewire.pages.home');
    }
}
