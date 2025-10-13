<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="#">Penjadwalan Aula</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="relative mb-2 mt-2 w-full">
        <flux:heading size="xl" level="1" class="mb-4">Jadwal Pemakaian Aula</flux:heading>
        {{-- <flux:subheading size="lg" class="mb-6"></flux:subheading> --}}
        <flux:separator variant="subtle" />
    </div>


    <div class="flex items-start max-md:flex-col">
        <div class="me-10 w-full pb-4 md:w-[220px]">
            <flux:input wire:model.live.debounce.250ms="date" type="date" class="w-full mb-4" label="Tanggal" />
            <flux:navlist>
                <flux:navlist.group heading="Aula" class="mt-4">

                    @foreach($halls as $hall)
                    <flux:navlist.item class="{{ $hall_id === $hall->id ? 'bg-neutral-100 dark:bg-neutral-800' : '' }}" wire:click.prevent="selectHall({{ $hall->id }})">{{ $hall->name }}</flux:navlist.item>
                    @endforeach

                </flux:navlist.group>
            </flux:navlist>
        </div>

        <flux:separator class="md:hidden" />

        <div class="flex-1 self-stretch max-md:pt-6">
            <flux:heading>{{ $heading ?? '' }}</flux:heading>
            <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

            <div class="mt-5 w-full">
                <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-5">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-md font-semibold">Aula {{ $selectedHall->name }}</h2>
                            </div>

                            <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium tracking-wider">Hari/ Tanggal/ Waktu
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium tracking-wider">Kegiatan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium tracking-wider">Keterangan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium tracking-wider">Penanggung Jawab
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                @forelse($times as $time)
                                <tr wire:key="time-{{ $time->id }}" class="{{ 
                        \Carbon\Carbon::now()->between(
                            $time->start_time->setDate($time->date->year, $time->date->month, $time->date->day),
                            $time->end_time->setDate($time->date->year, $time->date->month, $time->date->day)
                        ) ? 'bg-green-200' : ''
                    }}">
                                    <td class="px-6 py-4">{{ $time->date->format('l, d F Y') }} ({{ $time->start_time->format('H:i') }} - {{ $time->end_time->format('H:i') }})</td>
                                    <td class="px-6 py-4">{{ $time->schedule->event_name }}</td>
                                    <td class="px-6 py-4">{{ $time->schedule->description }}</td>
                                    <td class="px-6 py-4">{{ $time->schedule->responsible_person }} </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap">
                                        <p class="text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada data
                                            tersedia</p>
                                    </td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
