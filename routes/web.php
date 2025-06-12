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
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\InvoiceController;
Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])
        ->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::match(['get', 'post'], '/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::match(['get', 'post'], '/products', [ProductController::class, 'index'])->name('products.index');
    Route::match(['get', 'post'], '/products/search', [ProductController::class, 'search'])->name('products.search');
    Route::post('/products/update-clients', [ProductController::class, 'updateClients'])->name('products.update-clients');
    Route::get('/products/request', [ProductController::class, 'showRequestForm'])->name('products.request');
    Route::post('/products/request', [ProductController::class, 'storeRequest'])->name('products.request.store');
    Route::post('/orders/update-clients', [OrderController::class, 'updateClients'])->name('orders.update-clients');

    Route::get('/reports/{id}', [ReportViewController::class, 'show'])->name('reports.show');
    Route::get('/reports', [ReportViewController::class, 'index'])->name('reports.index');
    Route::match(['get', 'post'], '/profile', [ProfileController::class, 'show'])->name('profile.index');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

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

    // Route::get('/create-quotes-order', function () {
    //     $order = Http::businessCentral()->post('salesQuotes', [
    //         'customerNumber' => "K0000056",
    //         'shipToName' => 'AYTAC Foods Distribution Limited',
    //         'externalDocumentNumber' => "3312",
    //         'salesQuoteLines' => [
    //             [
    //                 'lineType' => 'Item',
    //                 'lineObjectNumber' => "E00.40.141-001",
    //                 'quantity' => 10,
    //                 'unitPrice' => 20.0
    //             ]
    //         ]
    //     ]);

    //     $orderData = $order->json();
    //     $orderId = $orderData['id'] ?? null;

    //     if (!$orderId) {
    //         dd('Order creation failed:', $order->body());
    //     }

    //     // Get sales lines and include item number using $expand
    //     $salesLines = Http::businessCentral()->get("salesOrders($orderId)/salesOrderLines?\$expand=item");

    //     // Dump everything
    //     dd([
    //         'Order' => $orderData,
    //         'Status' => $order->status(),
    //         'SalesLines' => $salesLines->json(),
    //     ]);
    // });

    // Invoice Routes
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{documentNo}', [InvoiceController::class, 'show'])->name('invoices.show');

});


    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [RegisterController::class, 'register']);

        Route::get('admin/reports', [ReportController::class, 'create'])->name('reports.create');
        Route::post('admin/reports', [ReportController::class, 'store'])->name('reports.store');
        Route::get('/admin/requests', [ProductController::class, 'adminRequests'])->name('admin.product-requests');
        Route::post('/admin/requests/{id}', [ProductController::class, 'handleRequest'])->name('admin.product-requests.handle');
            });


Route::aliasMiddleware('admin', AdminMiddleware::class);

Route::get('/logo-helper', function () {
    return view('logo-helper');
});
