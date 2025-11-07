<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [AdminController::class, 'toAdminLogin'])->name('login');

Route::get('/logout', function () {
    Auth::logout(); // Logs out the current user
    request()->session()->invalidate(); // Invalidate the session
    request()->session()->regenerateToken(); // Regenerate the CSRF token for security
    return redirect()->route('login'); // Redirect to the login page (or any other route)
})->name('logout');
