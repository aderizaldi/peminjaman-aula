<?php

use App\Livewire\Pages\CreateHallReservation;
use App\Livewire\Pages\Dashboard;
use App\Livewire\Pages\DetailHallReservation;
use App\Livewire\Pages\Hall;
use App\Livewire\Pages\HallReservation;
use App\Livewire\Pages\HallSchedule;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\UserManagement;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/peminjaman-aula', HallReservation::class)->name('dashboard.reservation');
    Route::get('/peminjaman-aula/create', CreateHallReservation::class)->name('dashboard.reservation.create');
    Route::get('/peminjaman-aula/{id}/detail', DetailHallReservation::class)->name('dashboard.reservation.detail');
    Route::get('/penjadwalan-aula', HallSchedule::class)->name('dashboard.schedule');

    Route::get('user', UserManagement::class)->middleware(['role:admin|operator'])->name('dashboard.user');
    Route::get('hall', Hall::class)->middleware(['role:admin|operator'])->name('dashboard.hall');
});


require __DIR__ . '/auth.php';
