<?php

namespace App\Livewire\Pages;

use App\Models\Hall;
use App\Models\Time;
use Livewire\Component;
use App\Enums\HallStatus;
use App\Enums\ScheduleStatus;

class HallSchedule extends Component
{
    public $hall_id;
    public $date;

    public $halls;
    public $selectedHall;

    public function mount()
    {
        $this->hall_id = Hall::first()->id;
        $this->date = now()->format('Y-m-d');

        $this->halls = Hall::where('status', HallStatus::ACTIVE)->get();
        $this->selectedHall = Hall::find($this->hall_id);
    }

    public function getTime()
    {
        $times = Time::where('date', $this->date)->whereRelation('schedule', 'hall_id', $this->hall_id)->whereRelation('schedule', 'status', ScheduleStatus::APPROVED)->orderBy('start_time')->get();
        return $times;
    }

    public function selectHall($id)
    {
        $this->hall_id = $id;
        $this->selectedHall = Hall::find($this->hall_id);
    }

    public function render()
    {
        return view(
            'livewire.pages.hall-schedule',
            [
                'times' => $this->getTime()
            ]
        );
    }
}
