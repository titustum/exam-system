<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


// my things
Volt::route('create-student', 'main.createstudent');

Volt::route('addmarks/{classRoomId}/{classRoomUnitId}/{examId}', 'main.add-marks')->name('add.scores');
Volt::route('viewmarks/{classRoomId}/{classRoomUnitId}/{examId}', 'main.view-marks')->name('view.scores');

require __DIR__.'/auth.php';
