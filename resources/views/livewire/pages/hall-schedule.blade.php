<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="#">Penjadwalan Aula</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-5">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Jadwal Pemakaian Aula</h2>
        </div>

        {{-- filter hall and date --}}
        <div class="flex items-center">
            <div class="flex items-center gap-2 mb-4 flex-wrap">
                <flux:select wire:model.live.debounce.250ms="hall_id" label="Aula" class="w-full">
                    @foreach ($halls as $hall)
                    <option value="{{ $hall->id }}">{{ $hall->name }}</option>
                    @endforeach
                </flux:select>
                <flux:input wire:model.live.debounce.250ms="date" type="date" class="w-full" label="Tanggal" />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                <thead>
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium tracking-wider">Aula
                        </th>
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
                    <tr wire:key="time-{{ $time->id }}">
                        <td class="px-6 py-4">{{ $time->schedule->hall->name }}</td>
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
