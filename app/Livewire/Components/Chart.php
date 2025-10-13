<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Chart extends Component
{
    protected $listeners = ['updateChart'];
    // Konfigurasi chart
    public $chartOptions = [];

    // ID unik untuk chart
    public $chartId;

    public function mount($chartOptions = [], $chartId = null)
    {
        $this->chartId = $chartId ?: 'chart-' . uniqid();

        // Opsi default jika tidak ada yang diberikan
        $this->chartOptions = $chartOptions ?: [
            'chart' => [
                'height' => 350,
                'type' => 'line',
                'toolbar' => [
                    'show' => false,
                ],
            ],
            'series' => [
                'name' => 'Nilai',
                'data' => [
                    ['x' => '2022-01-01', 'y' => 30],
                    ['x' => '2022-02-01', 'y' => 40],
                    ['x' => '2022-03-01', 'y' => 35],
                    ['x' => '2022-04-01', 'y' => 50],
                    ['x' => '2022-05-01', 'y' => 45],
                ],
            ],
            'dataLabels' => [
                'enabled' => false,
            ],
            'stroke' => [
                'curve' => 'smooth',
                'width' => 2,
            ],
            'title' => [
                'text' => 'Data Statistik',
                'align' => 'center',
            ],
            'xaxis' => [
                'type' => 'datetime',
            ],
            'yaxis' => [
                'title' => [
                    'text' => 'Nilai',
                ],
            ],
            'tooltip' => [
                'x' => [
                    'format' => 'dd MMM yyyy',
                ],
            ],
        ];
    }

    public function updateChart($params)
    {
        $chartOptions = $params[0];
        $chartId = $params[1];
        if ($chartId === $this->chartId) {
            $this->chartOptions = $chartOptions;
            $this->dispatch('update-chart', ['chartOptions' => $chartOptions, 'chartId' => $chartId]);
        }
    }

    public function refreshChart()
    {
        $this->dispatch('update-chart', ['chartOptions' => $this->chartOptions, 'chartId' => $this->chartId]);
    }
    public function render()
    {
        return view('livewire.components.chart');
    }
}
