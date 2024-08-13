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
Volt::route('create-student', 'pages.main.createstudent');
Volt::route('select-department', 'pages.main.select-department');

Volt::route('addmarks/{classRoomId}/{classRoomUnitId}/{examId}', 'pages.main.add-marks')->name('add.scores');
Volt::route('viewmarks/{classRoomId}/{classRoomUnitId}/{examId}', 'pages.main.view-marks')->name('view.scores');

require __DIR__.'/auth.php';
