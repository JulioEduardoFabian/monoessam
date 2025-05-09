<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\MineController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::post('users', [UsersController::class, 'store'])->name('users');
Route::post('roles', [RoleController::class, 'store'])->name('roles');
Route::post('areas', [AreaController::class, 'store'])->name('areas');
Route::delete('areas/{id}', [AreaController::class, 'destroy'])->name('areas.destroy');
Route::post('permissions', [PermissionController::class, 'store'])->name('permissions');
Route::delete('permissions/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

Route::post('mines', [MineController::class, 'store'])->name('mines');
Route::get('search-mine/{word}', [MineController::class, 'search'])->name('mines.search');

Route::post('role-permissions', [PermissionController::class, 'rolePermissions'])->name('role-permissions');
Route::post('role-user', [PermissionController::class, 'roleUser'])->name('role-user');



require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
