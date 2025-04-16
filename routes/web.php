<?php
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});


// Route::get('/customer/login', [AuthController::class, 'showLogin'])->name('login');
// Route::post('/customer/login', [AuthController::class, 'login']);
// Route::get('/customer/logout', [AuthController::class, 'logout'])->name('logout');



// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
// Route::post('/login', [LoginController::class, 'login'])->name('login');
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



// Route::get('/customer/dashboard', function () {
//     return view('dashboard');
// });

// Route::middleware('auth')->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });


Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::match(['get', 'post'], '/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::match(['get', 'post'], '/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products/search', [ProductController::class, 'search'])->name('products.search');
    Route::post('/products/update-clients', [ProductController::class, 'updateClients'])->name('products.update-clients');
    Route::post('/orders/update-clients', [OrderController::class, 'updateClients'])->name('orders.update-clients');

    Route::match(['get', 'post'], '/profile', [ProfileController::class, 'show'])->name('profile.index');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [RegisterController::class, 'register']);

        Route::get('admin/reports', [ReportController::class, 'create'])->name('reports.create');
        Route::post('admin/reports', [ReportController::class, 'store'])->name('reports.store');
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// Register the admin middleware
Route::aliasMiddleware('admin', AdminMiddleware::class);

Route::get('/logo-helper', function () {
    return view('logo-helper');
});
