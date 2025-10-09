    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('dashboard.reservation') }}">Peminjaman Aula</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#">Buat Peminjaman</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-5">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Buat Peminjaman</h2>
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
                    <flux:input type="file" label="Surat Permohonan" placeholder="Dokumen..." required wire:model="document" accept="application/pdf" />
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

                <div class="md:col-span-2 flex justify-end items-center">
                    <flux:button type="button" variant="primary" wire:click="create" icon="paper-airplane">Buat Peminjaman</flux:button>
                </div>
            </div>
        </div>

    </div>
