<div class="w-full h-full flex flex-col items-center justify-center">
    <div class="relative w-full h-0 overflow-hidden" style="padding-bottom: 56.25%;">
        <img src="{{ $images[$currentIndex] }}" wire:poll.5000ms="nextImage" alt="Slideshow" class="absolute top-0 left-0 w-full h-full object-contain">
    </div>
</div>
