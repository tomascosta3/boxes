<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\TypeController;
use App\Models\EquipmentModel;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Translation\MessageCatalogue;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * If the user is authenticated, he will be directed to "home",
 * otherwise to "login".
 */
Route::get('/', function() {
    return to_route('home');
})->middleware('auth');

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

/**
 * Authentication routes.
 */
Route::name('auth.')->group(function () {
    Route::get('/login', [LoginController::class, 'view'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.user');
    Route::get('/register', [RegisterController::class, 'view'])->name('register');
    Route::post('/register', [RegisterController::class, 'create'])->name('register.user');
    // Route::get('/verification/{token}', [RegisterController::class, 'verify'])->name('verify');
});


/**
 * Routes that only authenticated users can access.
 */
Route::middleware('auth')->group(function() {

    /**
     * Logout.
     */
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    /**
     * Only allow access to users that have technician permissions or superior.
     */
    Route::middleware(['is.technician'])->group(function() {

        // Client index.
        Route::get('/clients', [ClientController::class, 'index'])->name('clients');

        // Clients routes.
        Route::name('clients.')->group(function () {

            Route::get('/clients/get-formatted', [ClientController::class, 'get_clients'])->name('get-formatted');

            // Create client.
            Route::get('/clients/create', [ClientController::class, 'create'])->name('create');

            // Client store.
            Route::post('/clients/store', [ClientController::class, 'store'])->name('store');

            // Client store and return client data.
            Route::post('/clients/store-and-return', [ClientController::class, 'store_and_return_client_data'])->name('store-and-return-client-data');

            // Client view.
            Route::get('/clients/{id}', [ClientController::class, 'show'])->name('show');

            // Edit client info.
            Route::post('/clients/edit/{id}', [ClientController::class, 'edit'])->name('edit');

            // Soft delete client.
            Route::get('/clients/delete/{id}', [ClientController::class, 'delete'])->name('delete');
        });

        // Equipment index.
        Route::get('/equipment', [EquipmentController::class, 'index'])->name('equipments');

        // Equipments routes.
        Route::name('equipments.')->group(function () {
            // Create equipment.
            Route::get('/equipments/create', [EquipmentController::class, 'create'])->name('create');

            // Store equipment.
            Route::post('/equipments/store', [EquipmentController::class, 'store'])->name('store');

            // Generate serial number.
            Route::get('/equipments/serial-number', [EquipmentController::class, 'generate_unique_serial_number'])->name('serial-number');

            // Equipment view.
            Route::get('/equipments/{id}', [EquipmentController::class, 'show'])->name('show');

            // Edit equipment info.
            Route::post('/equipments/edit/{id}', [EquipmentController::class, 'edit'])->name('edit');

            // Soft delete equipment.
            Route::get('/equipments/delete/{id}', [EquipmentController::class, 'delete'])->name('delete');

            // Get client's equipments.
            Route::get('/equipments/get-by-client/{id}', [EquipmentController::class, 'get_equipments_by_client'])->name('get-by-client');

            // Get equipment that has a specific serial number.
            Route::get('/equipments/get-by-serial-number/{serial_number}', [EquipmentController::class, 'get_by_serial_number'])->name('get-by-serial-number');
        });

        // Types routes.
        Route::name('types.')->group(function() {
            // Save type.
            Route::post('/types/save', [TypeController::class, 'save_type'])->name('save');
        });

        // Brand routes.
        Route::name('brands.')->group(function() {
            // Save brand.
            Route::post('/brands/save', [BrandController::class, 'save_brand'])->name('save');

            // Get brand's type.
            Route::get('/brands/get-by-type/{id}', [BrandController::class, 'get_brands_by_type'])->name('get-by-type');
        });

        // Equipment models routes.
        Route::name('models.')->group(function() {
            // Save brand.
            Route::post('/models/save', [ModelController::class, 'save_model'])->name('save');

            // Get model's type.
            Route::get('/models/get-by-brand/{id}', [ModelController::class, 'get_models_by_brand'])->name('get-by-brand');
        });

        // New order.
        Route::get('/new-order', [OrderController::class, 'new'])->name('new-order');

        // Create new order.
        Route::post('/new-order', [OrderController::class, 'store'])->name('new-order.store');

        // Repairs routes.
        Route::name('orders.')->group(function () {
            // Show order.
            Route::get('/orders/{order_number}', [OrderController::class, 'show'])->name('show');

            // Print order.
            Route::get('/orders/{number}/print', [OrderController::class, 'print'])->name('print');
        });

        // Repairs index.
        Route::get('/repairs', [RepairController::class, 'index'])->name('repairs');

        // Repairs routes.
        Route::name('repairs.')->group(function () {
            // Equipment view.
            Route::get('/repairs/{id}', [RepairController::class, 'show'])->name('show');

            // Print repair.
            Route::get('/repairs/{id}/print', [RepairController::class, 'print'])->name('print');

            // Search repair.
            Route::post('/repairs/quick-search', [RepairController::class, 'quick_search'])->name('quick-search');

            // Edit repair.
            Route::post('/repairs/edit/{id}', [RepairController::class, 'edit'])->name('edit');

            // Deliver equipment.
            Route::post('/repairs/equipment/deliver', [RepairController::class, 'deliver'])->name('deliver');
        });

        // Messages routes.
        Route::name('messages.')->group(function () {
            // Save new message.
            Route::post('/save-message', [MessageController::class, 'save_message'])->name('save-message');

            // Get messages of specific binnacle.
            Route::get('/get-messages/{id}', [MessageController::class, 'get_messages'])->name('get-messages');
        });
    });
});