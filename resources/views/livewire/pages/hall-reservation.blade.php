<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="#">Peminjaman Aula</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    {{-- Button tambah jenis soal --}}
    <div class="flex justify-end items-center">
        <flux:button type="button" variant="primary" href="{{ route('dashboard.reservation.create') }}" icon="plus">Buat Peminjaman</flux:button>
    </div>

    <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-5">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Daftar Peminjaman Aula</h2>
            <div class="flex items-center">
                <flux:input type="search" wire:model.live.debounce.250ms="search" placeholder="Cari..." class="mr-2" />
            </div>
        </div>


        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                <thead>
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium tracking-wider">Aula
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium tracking-wider">Hari/Tanggal/Waktu
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium tracking-wider">Kegiatan
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium tracking-wider">Penanggung Jawab
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium tracking-wider">Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                    @forelse($schedules as $schedule)
                    <tr wire:key="schedule-{{ $schedule->id }}">
                        <td class="px-6 py-4">{{ $schedule->hall->name }}</td>
                        <td class="px-6 py-4">
                            <ul>
                                @foreach($schedule->times as $time)
                                <li>{{ $time->date->format('l, d F Y') }} ({{ $time->start_time->format('H:i') }} - {{ $time->end_time->format('H:i') }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-6 py-4">{{ $schedule->event_name }}</td>
                        <td class="px-6 py-4">{{ $schedule->responsible_person }} </td>
                        <td class="px-6 py-4">
                            <flux:badge color="{{ $schedule->status === 'approved' ? 'green' : ($schedule->status === 'rejected' ? 'red' : 'yellow') }}">{{ $schedule->status }}</flux:badge>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <flux:button type="button" wire:click="openModal('detail', {{ $schedule->id }})" size="xs">Detail
                            </flux:button>
                            @hasanyrole('admin|operator')
                            @if($schedule->status === 'pending')
                            <flux:button type="button" href="{{ route('dashboard.reservation.detail', $schedule->id) }}" variant="primary" color="yellow" size="xs">
                                Terima/Tolak</flux:button>
                            @endif
                            @endhasanyrole
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap">
                            <p class="text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada data
                                tersedia</p>
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $schedules->links() }}
        </div>
    </div>

    {{-- modal detail --}}
    @if($schedule)
    <flux:modal wire:model="modal.detail" class="min-w-sm md:min-w-xl space-y-4">
        <flux:heading size="lg">Detail Peminjaman</flux:heading>
        <div class="space-y-2">
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-3">
                <h3 class="text-md font-semibold">Aula:</h3>
                {{-- @dd($schedule) --}}
                <p>{{ $schedule->hall->name }}</p>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-3">
                <h3 class="text-md font-semibold">Hari/Tanggal/Waktu:</h3>
                <ul>
                    @foreach($schedule->times as $time)
                    <li>{{ $time->date->format('l, d F Y') }} ({{ $time->start_time->format('H:i') }} - {{ $time->end_time->format('H:i') }})</li>
                    @endforeach
                </ul>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-3">
                <h3 class="text-md font-semibold">Kegiatan:</h3>
                <p>{{ $schedule->event_name }}</p>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-3">
                <h3 class="text-md font-semibold">Penanggung Jawab:</h3>
                <p>{{ $schedule->responsible_person }}</p>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-3">
                <h3 class="text-md font-semibold">Deskripsi:</h3>
                <p>{{ $schedule->description }}</p>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-3">
                <h3 class="text-md font-semibold">Dokumen:</h3>
                @if($schedule->document)
                <flux:button type="button" href="{{ asset('storage/' . $schedule->document) }}" target="_blank" size="xs" icon="eye">Lihat
                    Dokumen</flux:button>
                @else
                <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada dokumen</p>
                @endif
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-3">
                <h3 class="text-md font-semibold">Status:</h3>
                <flux:badge color="{{ $schedule->status === 'approved' ? 'green' : ($schedule->status === 'rejected' ? 'red' : 'yellow') }}">{{ $schedule->status }}</flux:badge>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-3">
                <h3 class="text-md font-semibold">Diajukan Oleh:</h3>
                <p>{{ $schedule->user->name }}</p>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-3">
                <h3 class="text-md font-semibold">Disetujui Oleh:</h3>
                <p>{{ $schedule->approved_rejected_by?->name ?? '-'}}</p>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-3">
                <h3 class="text-md font-semibold">Notes:</h3>
                <p class="text-orange-500">{{ empty($schedule->notes) ? '-' : $schedule->notes }}</p>
            </div>
        </div>
        <div class="flex mt-4">
            @hasanyrole('admin|operator')
            <flux:button variant="danger" wire:click="openModal('delete', {{ $schedule->id }})" icon="trash">Hapus</flux:button>
            @endhasanyrole
            <flux:spacer />
            <flux:modal.close>
                <flux:button variant="primary">Kembali</flux:button>
            </flux:modal.close>
        </div>
    </flux:modal>
    <flux:modal wire:model="modal.delete" class="min-w-sm">
        <div class="space-y-4">
            <div>
                <flux:heading size="lg">Hapus?</flux:heading>
                <flux:subheading>
                    <p>Apakah Anda yakin ingin menghapus peminjaman ini.</p>
                    <p>Semua data yang berkaitan dengan peminjaman ini akan dihapus.</p>
                </flux:subheading>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Batal</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="red" wire:click="delete({{ $schedule->id }})">Hapus</flux:button>
            </div>
        </div>
    </flux:modal>
    @endif

    {{-- modal delete --}}

</div>
