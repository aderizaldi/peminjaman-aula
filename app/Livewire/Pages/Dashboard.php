<?php

namespace App\Livewire\Pages;

use App\Models\Hall;
use App\Models\Time;
use Livewire\Component;
use App\Enums\HallStatus;
use App\Enums\ScheduleStatus;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{

    public $hall_id = "all";
    public $halls;

    public $data_count;
    public $data_chart;

    public $chart_data;

    public function mount()
    {
        $this->halls = Hall::where('status', HallStatus::ACTIVE)->get();
        $this->data_count = [
            'total_hall' => Hall::where('status', HallStatus::ACTIVE)->count(),
            'total_time' => Time::whereRelation('schedule', 'status', ScheduleStatus::APPROVED)->count(),
            'total_time_today' => Time::whereRelation('schedule', 'status', ScheduleStatus::APPROVED)->where('date', now()->format('Y-m-d'))->count(),
        ];
    }

    public function updateChart()
    {
        $this->dispatch('update-chart', [
            [
                'chart' => [
                    'type' => 'bar',
                    'height' => 350,
                    'toolbar' => ['show' => false],
                ],
                'xaxis' => [
                    'categories' => $this->chart_data['labels'],
                ],
                'series' => [
                    [
                        'name' => 'Penggunaan Aula',
                        'data' => $this->chart_data['data'],
                    ],
                ],
                'dataLabels' => [
                    'enabled' => false,
                ],
                'colors' => ['#007bff', '#ffc107', '#fd7e14', '#6610f2'],
                'plotOptions' => [
                    'bar' => [
                        'borderRadius' => 4,
                        'borderRadiusApplication' => 'end',
                        'horizontal' => false,
                    ],
                ],
            ],
            'bar-chart'
        ]);
    }

    private function getMonthlyData($hall_id = null)
    {
        // Mendapatkan tanggal 12 bulan yang lalu
        $twelveMonthsAgo = now()->subMonths(12);

        // Mengambil data dari database
        $monthlyCounts = Time::select(
            DB::raw('count(*) as count'),
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month_year')
        )
            ->where('created_at', '>=', $twelveMonthsAgo)
            ->whereRelation('schedule', 'status', ScheduleStatus::APPROVED);

        if ($hall_id) {
            $monthlyCounts = $monthlyCounts->whereRelation('schedule', 'hall_id', $hall_id);
        }

        $monthlyCounts = $monthlyCounts->groupBy('month_year')
            ->orderBy('month_year', 'asc')
            ->get();

        // Menginisialisasi array untuk 12 bulan terakhir
        $months = [];
        $data = [];

        for ($i = 0; $i < 12; $i++) {
            $date = now()->subMonths(11 - $i);
            $months[] = $date->format('M Y');
            $data[$date->format('Y-m')] = 0;
        }

        // Mengisi array dengan data yang sebenarnya
        foreach ($monthlyCounts as $count) {
            $data[$count->month_year] = $count->count;
        }

        $this->chart_data = [
            'labels' => $months,
            'data' => array_values($data),
        ];
    }

    public function selectHall($hall_id)
    {
        if ($hall_id == "all") {
            $this->chart_data = $this->getMonthlyData();
            $this->updateChart();
            return;
        }
        $this->hall_id = $hall_id;
        $this->chart_data = $this->getMonthlyData($hall_id);
        $this->updateChart();
    }

    public function render()
    {
        return view('livewire.pages.dashboard', [
            'chart_data' => $this->getMonthlyData()
        ]);
    }
}
