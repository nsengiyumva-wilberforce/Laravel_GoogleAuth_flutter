<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

Route::get('/', function () {
    return view('sign-up');
});

Route::get('/auth/redirect', function() {
    return Socialite::driver('google')->redirect();
})->name('google.login');



Route::get('/dashboard', function() {
    //get logged in user
    $user = Auth::user();

    return view('dashboard', compact('user'));
})->middleware('auth');

Route::get('/logout', function() {
    Auth::logout();

    return redirect('/');
})->name('logout');
