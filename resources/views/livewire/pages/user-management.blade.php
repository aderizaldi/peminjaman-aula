<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="#">User</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    {{-- Button tambah jenis soal --}}
    <div class="flex justify-end items-center">
        <flux:button type="button" variant="primary" wire:click="openModal('create')" icon="plus">Tambah User</flux:button>
    </div>

    <!-- Tabel Users -->
    <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-5">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Daftar Users</h2>
            <div class="flex items-center">
                <flux:input type="search" wire:model.live.debounce.250ms="search" placeholder="Cari..." class="mr-2" />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                <thead>
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium tracking-wide">Nama
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium tracking-wide">Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium tracking-wide">Role
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium tracking-wide">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                    @forelse($users as $user)
                    <tr wire:key="user-{{ $user->id }}">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <flux:badge color="{{ $user->getRoleNames()[0] === 'operator' ? 'blue' : 'green' }}">{{ $user->getRoleNames()[0] }}</flux:badge>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <flux:button type="button" wire:click="openModal('update', {{ $user->id }})" size="xs">Edit
                            </flux:button>
                            <flux:button type="button" wire:click="openModal('delete', {{ $user->id }})" variant="danger" size="xs">
                                Hapus</flux:button>
                        </td>
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

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>

    {{-- Modal Tambah --}}
    <flux:modal wire:model="modal.create" class="min-w-sm md:min-w-xl space-y-4">
        <flux:heading size="lg">Tambah User</flux:heading>
        <form wire:submit="create">
            <div class="space-y-4">
                <flux:input label="Nama" wire:model="name" />
                <flux:input label="Email" wire:model="email" />
                <flux:input label="Password" wire:model="password" type="password" />
                <flux:input label="Ulangi Password" wire:model="password_confirmation" type="password" />
                <flux:select label="Role" wire:model="role">
                    <option value="user">User</option>
                    <option value="operator">Operator</option>
                </flux:select>
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

    {{-- Modal Edit --}}
    <flux:modal wire:model="modal.update" class="min-w-sm md:min-w-xl space-y-4" @close="resetForm" @cancel="resetForm">
        <flux:heading size="lg">Edit</flux:heading>
        <form wire:submit="update">
            <div class="space-y-4">
                <flux:input label="Nama" wire:model="name" />
                <flux:input label="Email" wire:model="email" />
                <flux:input label="Password" wire:model="password" type="password" description="*Biarkan kosong jika tidak ingin mengganti password" />
                <flux:input label="Ulangi Password" wire:model="password_confirmation" type="password" />
                <flux:select label="Role" wire:model="role">
                    <option value="user" @selected($role=='user' )>User</option>
                    <option value="operator" @selected($role=='operator' )>Operator</option>
                </flux:select>
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

    <!-- Modal Konfirmasi Delete -->
    <flux:modal wire:model="modal.delete" class="min-w-sm">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Hapus User?</flux:heading>

                <flux:subheading>
                    <p>Apakah Anda yakin ingin menghapus user ini.</p>
                    <p>Semua data yang berkaitan dengan user ini akan dihapus.</p>
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
