<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('dashboard.reservation') }}">Peminjaman Aula</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="#">Detail Peminjaman</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-5">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Detail Peminjaman</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex flex-col gap-4">
                <flux:select label="Aula" required wire:model="hall_id">
                    <option value="">--Pilih Aula--</option>
                    @foreach ($halls as $hall)
                    <option value="{{ $hall->id }}">{{ $hall->name }}</option>
                    @endforeach
                </flux:select>
                <flux:input type="text" label="Nama Kegiatan" placeholder="Kegiatan..." required wire:model="event_name" />
                <flux:input type="text" label="Penanggung Jawab" placeholder="Penanggung Jawab..." required wire:model="responsible_person" />
                <flux:textarea type="text" label="Deskripsi Kegiatan" placeholder="Deskripsi..." required wire:model="description" />
                {{-- document --}}
                <div>
                    <p class="text-sm font-semibold mb-1">Dokumen</p>
                    @if($document)
                    <flux:button type="button" variant="primary" color="blue" target="_blank" href="{{ $document }}" icon="eye">Lihat Dokumen</flux:button>
                    @else
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada dokumen</p>
                    @endif
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <h3 class="text-md font-semibold m-0 text-center">Waktu</h3>
                @foreach($times as $index => $time)
                <div wire:key="time-{{ $index }}" class="grid grid-cols-2 gap-2 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-3">
                    <div class="col-span-2">
                        <flux:input type="date" label="Tanggal" required wire:model="times.{{ $index }}.date" min="{{ now()->format('Y-m-d') }}" />
                    </div>
                    <flux:input type="time" label="Jam Mulai" required wire:model="times.{{ $index }}.start_time" />
                    <flux:input type="time" label="Jam Selesai" required wire:model="times.{{ $index }}.end_time" />
                    @if(count($times) > 1)
                    <div class="col-span-2 flex justify-end">
                        <button type="button" wire:click="removeTime({{ $index }})" class="text-sm text-red-500 hover:text-red-700">Hapus</button>
                    </div>
                    @endif
                </div>
                @endforeach

                <div class="flex justify-center">
                    <flux:button type="button" variant="filled" wire:click="addTime" icon="plus">Tambah Waktu</flux:button>
                </div>
            </div>
            <div class="md:col-span-2">
                <flux:separator />
            </div>
            <div class="md:col-span-2 flex flex-col gap-4">
                <h3 class="text-md font-semibold m-0 q text-center">Terima atau Tolak Permohonan</h3>
                <flux:textarea label="Notes" placeholder="Notes..." wire:model="notes" />
                <div class="flex justify-end gap-4">
                    <flux:button type="button" variant="primary" color="red" wire:click="openModal('reject')" icon="x-mark">Tolak</flux:button>
                    <flux:button type="button" variant="primary" color="green" wire:click="openModal('approve')" icon="check">Terima</flux:button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal terima --}}
    <flux:modal wire:model="modal.approve" class="min-w-sm">
        <div class="space-y-4">
            <div>
                <flux:heading size="lg">Terima?</flux:heading>
                <flux:subheading>
                    <p>Apakah Anda yakin ingin menerima permohonan ini.</p>
                </flux:subheading>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Batal</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="green" wire:click="approve">Terima</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- modal tolak --}}
    <flux:modal wire:model="modal.reject" class="min-w-sm">
        <div class="space-y-4">
            <div>
                <flux:heading size="lg">Tolak?</flux:heading>
                <flux:subheading>
                    <p>Apakah Anda yakin ingin menolak permohonan ini.</p>
                </flux:subheading>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Batal</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="red" wire:click="reject">Tolak</flux:button>
            </div>
        </div>
    </flux:modal>


</div>
