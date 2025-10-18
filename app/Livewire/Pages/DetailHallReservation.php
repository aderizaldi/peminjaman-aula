<?php

namespace App\Livewire\Pages;

use App\Models\Hall;
use App\Models\Time;
use Livewire\Component;
use App\Models\Schedule;
use App\Enums\HallStatus;
use App\Enums\ScheduleStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifAccHallReservation;
use App\Mail\NotifRejectHallReservation;

class DetailHallReservation extends Component
{
    public $halls;

    public $id = null;
    public $hall_id = '';
    public $event_name = '';
    public $responsible_person = '';
    public $description = '';
    public $document;
    public $times = [];
    public $notes = '';


    public $modal = [
        'approve' => false,
        'reject' => false
    ];

    public function openModal($modal)
    {
        $this->modal[$modal] = true;
    }

    public function closeModal($modal)
    {
        $this->modal[$modal] = false;
    }

    public function mount($id)
    {
        // Inisialisasi satu set formulir waktu saat pertama kali dimuat
        $this->halls = Hall::where('status', HallStatus::ACTIVE)->get();;

        $schedule = Schedule::find($id);
        $this->id = $schedule->id;
        $this->hall_id = $schedule->hall_id;
        $this->event_name = $schedule->event_name;
        $this->responsible_person = $schedule->responsible_person;
        $this->description = $schedule->description;
        $this->document = $schedule->document;

        foreach ($schedule->times as $time) {
            $this->times[] = [
                'date' => $time->date->format('Y-m-d'),
                'start_time' => $time->start_time->format('H:i'),
                'end_time' => $time->end_time->format('H:i'),
            ];
        }
    }

    public function addTime()
    {
        // Menambahkan set formulir waktu baru
        $this->times[] = ['date' => '', 'start_time' => '', 'end_time' => ''];
    }

    public function removeTime($index)
    {
        // Menghapus set formulir waktu berdasarkan index
        unset($this->times[$index]);
        $this->times = array_values($this->times); // Re-index array setelah penghapusan
    }

    public function approve()
    {
        $this->validate([
            'hall_id' => 'required',
            'event_name' => 'required',
            'responsible_person' => 'required',
            'description' => 'nullable',
            'document' => 'nullable|file|mimes:pdf',
            'notes' => 'nullable',
            'times.*.date' => 'required',
            'times.*.start_time' => 'required',
            'times.*.end_time' => 'required',
        ]);

        foreach ($this->times as $time) {
            $existingSchedule = Time::whereHas('schedule', function ($query) {
                $query->where('hall_id', $this->hall_id)
                    ->where('status', 'approved');
            })
                ->where('date', $time['date'])
                ->where(function ($query) use ($time) {
                    $query->whereBetween('start_time', [$time['start_time'], $time['end_time']])
                        ->orWhereBetween('end_time', [$time['start_time'], $time['end_time']])
                        ->orWhere(function ($q) use ($time) {
                            $q->where('start_time', '<', $time['start_time'])
                                ->where('end_time', '>', $time['end_time']);
                        });
                })
                ->exists();

            if ($existingSchedule) {
                $this->modal = [
                    'approve' => false,
                    'reject' => false
                ];
                $this->dispatch('showToast', status: 'error', message: 'Jadwal pada tanggal ' . $time['date'] . ', waktu ' . $time['start_time'] . ' - ' . $time['end_time'] . ' sudah ada sebelumnya.');
                return;
            }
        }

        $schedule = Schedule::find($this->id);
        $schedule->update([
            'hall_id' => $this->hall_id,
            'event_name' => $this->event_name,
            'responsible_person' => $this->responsible_person,
            'description' => $this->description,
            'status' => ScheduleStatus::APPROVED,
            'notes' => $this->notes,
            'approved_rejected_by' => Auth::id()
        ]);

        $schedule->times()->delete();
        foreach ($this->times as $time) {
            $schedule->times()->create([
                'date' => $time['date'],
                'start_time' => $time['start_time'],
                'end_time' => $time['end_time'],
            ]);
        }

        try {
            Mail::to($schedule->user->email)->send(new NotifAccHallReservation($schedule));
        } catch (\Throwable $th) {
            //throw $th;
        }

        return redirect()->route('dashboard.reservation')->with('showToast', [
            'status' => 'success',
            'message' => 'Permohonan berhasil disetujui',
        ]);
    }

    public function reject()
    {
        $this->validate([
            'notes' => 'nullable',
        ]);

        $schedule = Schedule::find($this->id);
        $schedule->update([
            'status' => ScheduleStatus::REJECTED,
            'notes' => $this->notes,
            'approved_rejected_by' => Auth::id()
        ]);

        try {
            Mail::to($schedule->user->email)->send(new NotifRejectHallReservation($schedule));
        } catch (\Throwable $th) {
            //throw $th;
        }

        return redirect()->route('dashboard.reservation')->with('showToast', [
            'status' => 'success',
            'message' => 'Permohonan telah ditolak',
        ]);
    }

    public function render()
    {
        return view('livewire.pages.detail-hall-reservation');
    }
}
