<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">

    {{ $slot }}

    @livewire('components.toast-notification')

    @include('partials.foot')

    @fluxScripts
</body>
</html>
