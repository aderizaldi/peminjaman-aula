<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="#">Gambar</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    {{-- Button tambah jenis soal --}}
    <div class="flex justify-end items-center">
        <flux:button type="button" variant="primary" wire:click="openModal('create')" icon="plus">Tambah Gambar</flux:button>
    </div>

    <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-5">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Daftar Gambar</h2>
            <div class="flex items-center">
                <flux:input type="search" wire:model.live.debounce.250ms="search" placeholder="Cari..." class="mr-2" />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                <thead>
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium tracking-wider">Judul
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium tracking-wider">Gambar
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                    @forelse($images as $image)
                    <tr wire:key="image-{{ $image->id }}">
                        <td class="px-6 py-4">{{ $image->name }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ asset('storage/' . $image->image) }}" target="_blank">
                                <img src="{{ asset('storage/' . $image->image) }}" alt="" class="w-32 h-32 object-contain">
                            </a>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <flux:button type="button" wire:click="openModal('delete', {{ $image->id }})" variant="danger" size="xs">
                                Hapus</flux:button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 whitespace-nowrap">
                            <p class="text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada data
                                tersedia</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $images->links() }}
        </div>
    </div>

    {{-- modal tambah --}}
    <flux:modal wire:model="modal.create" class="min-w-sm md:min-w-xl space-y-4">
        <flux:heading size="lg">Tambah Gambar</flux:heading>
        <form wire:submit="create">
            <div class="space-y-4">
                <flux:input label="Judul" wire:model="name" />
                <flux:input type="file" label="Gambar" wire:model="image" accept="image/*" />
            </div>
            <div class="flex gap-2 mt-4">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Batal</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary">Simpan</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- modal hapus --}}
    <flux:modal wire:model="modal.delete" class="min-w-sm">
        <div class="space-y-4">
            <div>
                <flux:heading size="lg">Hapus?</flux:heading>
                <flux:subheading>
                    <p>Apakah Anda yakin ingin menghapus gambar ini.</p>
                    <p>Semua data yang berkaitan dengan gambar ini akan dihapus.</p>
                </flux:subheading>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Batal</flux:button>
                </flux:modal.close>
                <flux:button variant="danger" wire:click="delete">Hapus</flux:button>
            </div>
        </div>
    </flux:modal>

</div>
