<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="#">Dashboard</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="grid gap-6 sm:grid-cols-1 lg:grid-cols-3">
        <div class="relative flex items-center justify-center flex-col rounded-2xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-6 hover:shadow-md transition-all">
            <flux:icon name="building-office-2" class="mb-2 h-10 w-10 text-green-500" />

            <p class="text-md text-neutral-500 dark:text-neutral-400 mb-1">Jumlah Aula</p>
            <p class="text-5xl font-bold text-neutral-800 dark:text-white">{{ $data_count['total_hall'] }}</p>
        </div>

        <div class="relative flex items-center justify-center flex-col rounded-2xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-6 hover:shadow-md transition-all">
            <flux:icon name="calculator" class="mb-2 h-10 w-10 text-blue-500" />
            <p class="text-md text-neutral-500 dark:text-neutral-400 mb-1">Jumlah Kegiatan</p>
            <p class="text-5xl font-bold text-neutral-800 dark:text-white">{{ $data_count['total_time'] }}</p>
        </div>

        <div class="relative flex items-center justify-center flex-col rounded-2xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-6 hover:shadow-md transition-all">
            <flux:icon name="newspaper" class="mb-2 h-10 w-10 text-orange-500" />

            <p class="text-md text-neutral-500 dark:text-neutral-400 mb-1">Jumlah Kegiatan Hari Ini</p>
            <p class="text-5xl font-bold text-neutral-800 dark:text-white">{{ $data_count['total_time_today'] }}</p>
        </div>
    </div>

    <div class="relative h-full w-full overflow-hidden rounded-2xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-6 hover:shadow-md transition-all">
        <div class="flex justify-between align-items-center mb-4">
            <p class="text-lg font-semibold text-neutral-700 dark:text-white mb-4">Statistik Penggunaan Aula</p>
            <flux:select wire:change="selectHall($event.target.value)" class="w-100!">
                <flux:select.option value="all" label="Semua Aula" />
                @foreach ($halls as $hall)
                <flux:select.option value="{{ $hall->id }}" label="{{ $hall->name }}" />
                @endforeach
            </flux:select>
        </div>
        <livewire:components.chart chart-id="bar-chart" :chart-options="
            [
                'chart' => [
                    'type' => 'bar',
                    'height' => 350,
                    'toolbar' => ['show' => false],
                ],
                'xaxis' => [
                    'categories' => $chart_data['labels'],
                ],
                'series' => [
                    [
                        'name' => 'Penggunaan Aula',
                        'data' => $chart_data['data'],
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
            ]
    " />
    </div>

</div>
