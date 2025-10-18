<?php

namespace App\Livewire\Pages;

use App\Models\Hall;
use App\Models\Time;
use App\Models\User;
use Livewire\Component;
use App\Models\Schedule;
use App\Enums\HallStatus;
use App\Enums\ScheduleStatus;
use Livewire\WithFileUploads;
use App\Mail\NotifHallReservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CreateHallReservation extends Component
{
    use WithFileUploads;

    public $halls;

    public $hall_id = '';
    public $event_name = '';
    public $responsible_person = '';
    public $description = '';
    public $document;
    public $times = [];

    public function mount()
    {
        // Inisialisasi satu set formulir waktu saat pertama kali dimuat
        $this->times[] = ['date' => '', 'start_time' => '', 'end_time' => ''];
        $this->halls = Hall::where('status', HallStatus::ACTIVE)->get();;
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

    public function create()
    {
        $this->validate([
            'hall_id' => 'required',
            'event_name' => 'required',
            'responsible_person' => 'required',
            'description' => 'nullable',
            'document' => 'nullable|file|mimes:pdf',
            'times.*.date' => 'required',
            'times.*.start_time' => 'required',
            'times.*.end_time' => 'required',
        ]);

        foreach ($this->times as $time) {
            // Ambil start_time dan end_time dari array $time
            $startTime = $time['start_time'];
            $endTime = $time['end_time'];

            $existingSchedule = Time::whereHas('schedule', function ($query) {
                $query->where('hall_id', $this->hall_id)
                    ->where('status', 'approved');
            })
                ->where('date', $time['date'])
                ->where(function ($query) use ($startTime, $endTime) {
                    // Logika untuk memeriksa tumpang tindih
                    $query->where(function ($q) use ($startTime, $endTime) {
                        // Kasus 1: Jadwal baru dimulai di tengah jadwal yang sudah ada.
                        // ⏰ [jadwal lama] |start_time baru|
                        $q->where('start_time', '<', $endTime)
                            ->where('end_time', '>', $startTime);
                    });
                })
                ->exists();

            if ($existingSchedule) {
                $this->dispatch('showToast', status: 'error', message: 'Jadwal pada tanggal ' . $time['date'] . ', waktu ' . $startTime . ' - ' . $endTime . ' sudah ada sebelumnya.');
                return;
            }
        }

        $schedule = Schedule::create([
            'hall_id' => $this->hall_id,
            'event_name' => $this->event_name,
            'responsible_person' => $this->responsible_person,
            'description' => $this->description,
            'document' => $this->document ? $this->document->store('schedules') : null,
            'user_id' => Auth::id(),
            'status' => Auth::user()->hasAnyRole('admin|operator') ? ScheduleStatus::APPROVED : ScheduleStatus::PENDING,
        ]);

        foreach ($this->times as $time) {
            $schedule->times()->create([
                'date' => $time['date'],
                'start_time' => $time['start_time'],
                'end_time' => $time['end_time'],
            ]);
        }

        try {
            if (Auth::user()->hasRole('user')) {
                // get user that have role admin or operator
                $users = User::whereHas('roles', function ($query) {
                    $query->where('name', 'admin')
                        ->orWhere('name', 'operator');
                })->get();
                foreach ($users as $user) {
                    Mail::to($user->email)->send(new NotifHallReservation($schedule));
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        return redirect()->route('dashboard.reservation')->with('showToast', [
            'status' => 'success',
            'message' => 'Peminjaman aula berhasil dibuat',
        ]);
    }

    public function render()
    {
        return view('livewire.pages.create-hall-reservation');
    }
}
