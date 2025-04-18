<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');



Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $users = User::all()->except(auth()->user()->id);
        return view('dashboard', compact('users'));
    })->name('dashboard');

    Route::get('/chat/{user}', function (User $user) {
        return view('chat', compact('user'));
    })->name('chat');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
