<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CafeController;
use App\Http\Controllers\DealershipController;
use App\Http\Controllers\DinnerController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\MineController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SubdealershipController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

Route::get('/', function () {
    return Inertia::render('auth/Login');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/migrate', function () {
    Artisan::call('migrate');
    dd('migrated!');
});

Route::get('/users', [UsersController::class, 'index']);
Route::get('/management', [ManagementController::class, 'index'])->name('management');
Route::get('/food', [FoodController::class, 'index'])->name('food');
Route::get('/businesses', [BusinessController::class, 'index'])->name('businesses');
Route::post('/business-services', [BusinessController::class, 'businessServices'])->name('businessServices');
Route::get('/structure-menu', [FoodController::class, 'structure'])->name('structure-menu');
//Route::get('/sales', [SaleController::class, 'index'])->name('sales');

Route::get('/dinners', [DinnerController::class, 'index'])->name('dinners');
Route::post('/dinners-excel', [DinnerController::class, 'excel'])->name('dinners.excel');
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::post('/services', [ServiceController::class, 'store'])->name('services.insert');
Route::put('/services-prices', [ServiceController::class, 'updatePrices'])->name('services.update-prices');

Route::post('/mine-serviceables', [MineController::class, 'mineServiceables'])->name('mineServiceables');
Route::post('/unit-serviceables', [UnitController::class, 'unitServiceables'])->name('unitServiceables');
Route::post('/cafe-serviceables', [CafeController::class, 'cafeServiceables'])->name('cafeServiceables');

Route::post('users', [UsersController::class, 'store'])->name('users');
Route::post('roles', [RoleController::class, 'store'])->name('roles');
Route::post('areas', [AreaController::class, 'store'])->name('areas');
Route::post('permissions', [PermissionController::class, 'store'])->name('permissions');

Route::delete('areas/{id}', [AreaController::class, 'destroy'])->name('areas.destroy');
Route::delete('permissions/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

Route::post('mines', [MineController::class, 'store'])->name('mines');
Route::post('units', [UnitController::class, 'store'])->name('units');
Route::post('cafes', [CafeController::class, 'store'])->name('cafes');
Route::post('sales', [SaleController::class, 'store'])->name('cafes');

Route::post('dealerships', [DealershipController::class, 'store'])->name('dealerships');
Route::post('subdealerships', [SubdealershipController::class, 'store'])->name('subdealerships');

Route::get('search-mine/{word}', [MineController::class, 'search'])->name('mines.search');
Route::get('search-unit/{word}', [UnitController::class, 'search'])->name('units.search');
Route::get('search-dish/{word}', [DishController::class, 'search'])->name('units.search');
Route::get('search-dinner/{word}/{id}', [DinnerController::class, 'search'])->name('units.search');

Route::get('print-test', [CafeController::class, 'printTest']);

Route::post('role-permissions', [PermissionController::class, 'rolePermissions'])->name('role-permissions');
Route::post('role-user', [PermissionController::class, 'roleUser'])->name('role-user');

Route::get('/qr/{id}', function ($id) {
    $arrayProducts = [
        1 => ['id' => 1, 'name' => 'Laptop Dell XPS 13', 'url' => '/products/1'],
        2 => ['id' => 2, 'name' => 'Proyector Epson', 'url' => '/products/2'],
        3 => ['id' => 3, 'name' => 'Impresora HP LaserJet', 'url' => '/products/3'],
        4 => ['id' => 4, 'name' => 'Monitor Samsung 24"', 'url' => '/products/4'],
        5 => ['id' => 5, 'name' => 'Teclado Mecánico Logitech', 'url' => '/products/5'],
        6 => ['id' => 6, 'name' => 'Mouse Inalámbrico Logitech', 'url' => '/products/6'],
        7 => ['id' => 7, 'name' => 'Disco Duro Externo Seagate', 'url' => '/products/7'],
        8 => ['id' => 8, 'name' => 'Router TP-Link Archer C6', 'url' => '/products/8'],
    ];

    // Verificar si el producto existe
    if (!array_key_exists($id, $arrayProducts)) {
        return response()->json(['error' => 'Product not found'], 404);
    }

    // Redirigir a la URL del producto
    //return redirect()->to($arrayProducts[$id]['url']);

    // Alternativa: Devolver los datos del producto como JSON
    return response()->json($arrayProducts[$id]);
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
