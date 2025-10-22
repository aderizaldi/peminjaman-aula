<div class="flex flex-col h-min-screen lg:h-screen bg-[#efefef]">
    <div class="basis-9/9 lg:basis-8/9 flex flex-row flex-wrap">
        <div class="lg:hidden basis-16/16 p-6 pb-0 flex flex-col justify-between">
            <div class="size-full bg-[#30bced] rounded-xl p-4 flex flex-col">
                <div class="flex flex-col">
                    <div class="w-full h-fit p-2 flex justify-center">
                        <img src="{{ asset('assets/img/singkawang.png') }}" alt="Logo Singkawang" class="w-12 object-contain">
                    </div>
                    <div class="text-center">
                        <h1 class="text-lf font-semibold text-[#050401]">Dinas Pendidikan dan Kebudayaan</h1>
                    </div>
                </div>
                <div class="flex flex-col gap-1 p-4">
                    <h1 class="text-md font-semibold text-[#050401] text-center ">Aula:</h1>
                    @foreach($halls as $hall)
                    <flux:button type="button" class="!bg-[#050401] !border-0 !text-[#fffaff] cursor-pointer hover:shadow-md" size="sm" wire:click="selectHall({{ $hall->id }})">{{ $hall->name }}</flux:button>
                    @endforeach
                </div>

            </div>
        </div>
        <div class="basis-2/16 bg-[#30bced] p-2 hidden lg:flex lg:flex-col justify-between">
            <div class="flex flex-col">
                <div class="w-full h-fit p-2 flex justify-center mt-4">
                    <img src="{{ asset('assets/img/singkawang.png') }}" alt="Logo Singkawang" class="w-16 object-contain">
                </div>
                <div class="text-center p-2">
                    <h1 class="text-md font-semibold text-[#050401]">Dinas Pendidikan dan Kebudayaan</h1>
                </div>
            </div>
            <div class="flex flex-col gap-1 p-4">
                <h1 class="text-lg font-semibold text-[#050401] text-center ">Aula:</h1>
                @foreach($halls as $hall)
                <flux:button type="button" class="w-full !bg-[#050401] !border-0 !text-[#fffaff] cursor-pointer hover:shadow-md" wire:click="selectHall({{ $hall->id }})">{{ $hall->name }}</flux:button>
                @endforeach
            </div>
            <div class="flex flex-col justify-center gap-4">
                <div class="flex justify-center">
                    <img src="{{ asset('assets/img/berakhlak.png') }}" alt="Logo BerAKHLAK" class="h-10 object-contain">
                </div>
                <div class="flex justify-center">
                    <img src="{{ asset('assets/img/bangga-melayani-bangsa.png') }}" alt="Logo Bangga Melayani Bangsa" class="h-10 object-contain">
                </div>
            </div>
        </div>

        <div class="h-[100vh] lg:h-[calc(100vh*8/9)] basis-full lg:basis-10/16 p-6 flex flex-col items-center justify-center w-screen" wire:poll.30s="nextScreen">
            @switch($currentScreen)
            @case('screen1')
            <div class="size-full bg-[#fffaff] rounded-xl p-4 flex flex-col">
                <h2 class="text-4xl font-semibold text-[#050401] text-center p-4" data-hall-id="{{ $selected_hall->id }}">
                    AULA {{ strtoupper($selected_hall->name) }}
                </h2>
                <div class="flex-grow overflow-y-auto overflow-x-auto" id="table-container">
                    <table class="min-w-full divide-y text-[#050401] divide-gray-200 dark:divide-neutral-700">
                        <thead class="bg-[#fffaff] z-10 sticky top-0">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-lg font-bold tracking-wider">Waktu</th>
                                <th scope="col" class="px-6 py-3 text-left text-lg font-bold tracking-wider">Kegiatan</th>
                                <th scope="col" class="px-6 py-3 text-left text-lg font-bold tracking-wider">Keterangan</th>
                                <th scope="col" class="px-6 py-3 text-left text-lg font-bold tracking-wider">Penanggung Jawab</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700 text-lg" wire:poll.60s="updateTimes">
                            @forelse($times as $time)
                            <tr wire:key="time-{{ $time->id }}" class="{{
                                $time_now?->id == $time->id ? 'bg-[#fc5130] now' : ''
                            }} {{ now()->format('H:i') > $time->end_time->format('H:i') ? 'text-gray-500' : '' }}">
                                <td class="px-6 py-4 text-nowrap">{{ $time->start_time->format('H:i') }} - {{ $time->end_time->format('H:i') }}</td>
                                <td class="px-6 py-4">{{ $time->schedule->event_name }}</td>
                                <td class="px-6 py-4">{{ empty($time->schedule->description) ? '-' : $time->schedule->description }}</td>
                                <td class="px-6 py-4">{{ $time->schedule->responsible_person }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada kegiatan</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @break
            @case('screen2')
            <div class="size-full bg-[#fffaff] rounded-xl p-4 flex flex-col">
                <div class="flex-grow flex flex-col justify-center items-center">
                    <h2 class="text-5xl font-semibold text-[#050401] text-center p-2" data-hall-id="{{ $selected_hall->id }}">
                        AULA {{ strtoupper($selected_hall->name) }}
                    </h2>
                    @if($time_now)
                    <h3 class="text-2xl font-semibold text-[#050401] text-center p-2">{{ $time_now->start_time->format('H:i') }} - {{ $time_now->end_time->format('H:i') }}</h3>
                    <h3 class="text-4xl font-semibold text-[#050401] text-center p-2">{{ $time_now->schedule->event_name }}</h3>
                    <h3 class="text-lg font-semibold text-[#050401] text-center p-2">{{ empty($time_now->schedule->description) ? '-' : $time_now->schedule->description }}</h3>
                    @else
                    <h3 class="text-4xl font-semibold text-gray-500 text-center p-2 ">Tidak ada kegiatan saat ini</h3>
                    @endif
                </div>
            </div>
            @break
            @endswitch


        </div>

        <div class="h-[100vh] lg:h-full basis-full lg:basis-4/16 p-6 pt-0 lg:pt-6 lg:ps-0 flex flex-col">
            <div class="basis-2/8 items-center justify-center flex pb-3">
                <div class="size-full bg-[#050401] rounded-xl p-4">
                    <livewire:components.clock />
                </div>
            </div>
            <div class="basis-3/8 items-center justify-center flex pt-3 pb-3">
                <div class="size-full bg-[#fffaff] rounded-xl p-4">
                    <livewire:components.video />
                </div>

            </div>
            <div class="basis-3/8 items-center justify-center flex pt-3">
                <div class="size-full bg-[#fc5130] rounded-xl p-4">
                    <livewire:components.image />
                </div>
            </div>
        </div>
    </div>
    <div class="basis-1/9 bg-[#30bced] p-2 items-center justify-between hidden lg:flex lg:flex-row">
        {{-- copyright --}}
        <div class="flex items-center gap-3 ms-6">
            <div class="flex flex-col justify-center">
                <p class="text-xs font-light text-[#050401]">© 2025 Dinas Pendidikan dan Kebudayaan Kota Singkawang</p>
            </div>
        </div>
        <div class="flex items-center gap-3 me-6">
            <div class="flex flex-col justify-center">
                <p class="text-xs font-light text-[#050401]">Telepon/Whatsapp: +62 813 4941 4007</p>
                <p class="text-xs font-light text-[#050401]">Email: <a href="mailto:disdikbud@singkawangkota.go.id" target="_blank">disdikbud@singkawangkota.go.id</a></p>


                {{-- <p class="text-xs font-light text-[#050401]">Alamat: Jl. Alianyang No. 1 Singkawang 79123</p> --}}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Fungsi untuk scroll ke highlighted row
    function scrollToHighlighted() {
        const container = document.getElementById('table-container');
        const highlightedRow = document.querySelector('.now');

        if (highlightedRow && container) {
            // Hitung posisi scroll
            const scrollTop = highlightedRow.offsetTop - container.offsetTop - (container.clientHeight / 2) + (highlightedRow.clientHeight / 2);

            container.scrollTo({
                top: scrollTop
                , behavior: 'smooth'
            });
        }
    }

    document.addEventListener('livewire:initialized', () => {
        let lastUpdateTime = Date.now();
        let lastHallId = document.querySelector('h2[data-hall-id]') === null ? '' : document.querySelector('h2[data-hall-id]').getAttribute('data-hall-id');


        Livewire.hook('morph.updated', ({
            component
        }) => {
            const currentTime = Date.now();
            const currentHallId = document.querySelector('h2[data-hall-id]') === null ? '' : document.querySelector('h2[data-hall-id]').getAttribute('data-hall-id');


            // Auto scroll jika ganti hall
            if (currentHallId !== lastHallId && lastHallId !== '') {
                setTimeout(scrollToHighlighted, 500);
                lastHallId = currentHallId;
                lastUpdateTime = currentTime;
            }
            // Atau scroll jika sudah lewat 55 detik
            else if (currentTime - lastUpdateTime > 55000) {
                setTimeout(scrollToHighlighted, 300);
                lastUpdateTime = currentTime;
            }

            // Update lastHallId jika pertama kali
            if (lastHallId === '') {
                lastHallId = currentHallId;
            }
        });
    });


    // Jalankan scroll pertama kali saat halaman selesai dimuat
    window.addEventListener('load', () => {
        setTimeout(scrollToHighlighted, 1000);
    });

</script>
@endpush
