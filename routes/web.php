<?php
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportViewController;
use App\Http\Controllers\BusinessCentralController;
use App\Http\Controllers\ClientOrderController;
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

    Route::get('/reports/{id}', [ReportViewController::class, 'show'])->name('reports.show');
    Route::get('/reports', [ReportViewController::class, 'index'])->name('reports.index');
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

    // Client Order Routes
    Route::get('order/create', [ClientOrderController::class, 'create'])->name('client-orders.create');
    Route::post('order/store', [ClientOrderController::class, 'store'])->name('client-orders.store');
    Route::get('quotes', [ClientOrderController::class, 'index'])->name('client-orders.index');
    Route::get('quotes/{id}', [ClientOrderController::class, 'show'])->name('client-orders.show');
    Route::get('quotes/{id}/edit', [ClientOrderController::class, 'edit'])->name('client-orders.edit');
    Route::put('quotes/{id}', [ClientOrderController::class, 'update'])->name('client-orders.update');

    
    Route::get('/create-quotes-order', function () {
        $order = Http::businessCentral()->post('salesQuotes', [
            'customerNumber' => "K0000056",
            'shipToName' => 'AYTAC Foods Distribution Limited',
            'externalDocumentNumber' => "3312",
            'salesQuoteLines' => [
                [
                    'lineType' => 'Item',
                    'lineObjectNumber' => "E00.40.141-001",
                    'quantity' => 10,
                    'unitPrice' => 20.0
                ]
            ]
        ]);
    
        $orderData = $order->json();
        $orderId = $orderData['id'] ?? null;
    
        if (!$orderId) {
            dd('Order creation failed:', $order->body());
        }
    
        // Get sales lines and include item number using $expand
        $salesLines = Http::businessCentral()->get("salesOrders($orderId)/salesOrderLines?\$expand=item");
    
        // Dump everything
        dd([
            'Order' => $orderData,
            'Status' => $order->status(),
            'SalesLines' => $salesLines->json(),
        ]);
    });
    
    
});

Route::aliasMiddleware('admin', AdminMiddleware::class);

Route::get('/logo-helper', function () {
    return view('logo-helper');
});
