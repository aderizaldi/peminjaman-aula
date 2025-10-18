<!DOCTYPE html>
<html>

<head>
    <title>Peminjaman Aula Dinas Pendidikan dan Kebudayaan Kota Singkawang</title>
</head>

<body>
    <h1>Permohonan Peminjaman Aula oleh {{ $schedule->user->name }}</h1>
    <p>Aula: {{ $schedule->hall->name }}</p>
    <p>Kegiatan: {{ $schedule->event_name }}</p>
    <p>Penanggung Jawab: {{ $schedule->responsible_person }}</p>
    <p>Deskripsi: {{ $schedule->description }}</p>
    <p>Hari/Tanggal/Waktu:</p>
    <ul>
        @foreach ($schedule->times as $time)
        <li>{{ $time->date->format('l, d F Y') }} ({{ $time->start_time->format('H:i') }} - {{ $time->end_time->format('H:i') }})</li>
        @endforeach
    </ul>

    @if ($schedule->document)
    <p>Dokumen: <a href="asset('storage/{{ $schedule->document }}')">Lihat Dokumen</a></p>
    @endif

    <p>Mohon setujui/tolak permohonan peminjaman aula melalui <a href="{{ route('dashboard.reservation.detail', ['id' => $schedule->id]) }}">{{ route('dashboard.reservation.detail', ['id' => $schedule->id]) }}</a></p>
</body>

</html>
