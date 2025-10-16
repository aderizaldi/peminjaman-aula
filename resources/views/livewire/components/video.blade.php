<div class="w-full h-full flex flex-col items-center justify-center" wire:poll.3600s="updateVideo">
    <div class="relative w-full h-0 overflow-hidden" style="padding-bottom: 56.25%;">
        <iframe class="absolute top-0 left-0 w-full h-full" src="{{ $link }}&rel=0&autoplay=1&mute=0&loop=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share;" referrerpolicy="strict-origin-when-cross-origin"></iframe>
    </div>
</div>
