<div class="w-full h-full flex flex-col items-center justify-center text-[#fffaff] gap-2">
    <div class="flex gap-2">
        <flux:button type="button" size="xs" class="mb-2 w-fit !bg-[#fffaff] !border-0 !text-[#050401] cursor-pointer hover:shadow-md" :href="route('login')" icon="arrow-right-start-on-rectangle">Login</flux:button>
        <flux:button type="button" size="xs" class="mb-2 w-fit !bg-[#fc5130] !border-0 !text-[#050401] cursor-pointer hover:shadow-md" href="https://self-19.gitbook.io/sipaula/" target="_blank" icon="book-open">Panduan</flux:button>
    </div>
    <h2 wire:poll.3600s="updateDate" class="text-lg font-bold text-center">{{ $currentDate }}</h2>
    <h2 wire:poll.1000ms="updateTime" class="text-4xl font-bold">{{ $currentTime }}</h2>
</div>
