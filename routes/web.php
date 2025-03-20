<?php
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/customer/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/customer/login', [AuthController::class, 'login']);
Route::get('/customer/logout', [AuthController::class, 'logout'])->name('logout');


Route::post('/login', function (Request $request) {
    // Simple check for username and password (no database)
    $username = $request->input('username');
    $password = $request->input('password');

    // Hardcoded username and password
    if ($username === 'admin' && $password === 'password123') {
        // Redirect to dashboard or any other page
        return redirect('/dashboard');
    }

    // If login fails
    return back()->withErrors(['error' => 'Invalid username or password']);
});


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



Route::get('/customer/dashboard', function () {
    return view('dashboard');
});
