<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="#">Video</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-5">
        <div class="flex flex-col gap-2">
            <div class="">
                <flux:input label="Link Video" wire:model="link" type="text" placeholder="https://www.youtube.com/embed/..." label="Link Video" description="*Masukkan link embed video youtube" />
            </div>
            {{-- save --}}
            <div class="flex justify-end items-center">
                <flux:button type="button" variant="primary" wire:click="update" icon="paper-airplane">Simpan</flux:button>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-5">
        <livewire:components.video />
    </div>
</div>
