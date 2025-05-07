<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/migrate', function () {
    Artisan::call('migrate');
    dd('migrated!');
});

Route::post('users', [UsersController::class, 'store'])->name('users');
Route::post('roles', [RoleController::class, 'store'])->name('roles');
Route::post('permissions', [PermissionController::class, 'store'])->name('permissions');
Route::post('role-permissions', [PermissionController::class, 'rolePermissions'])->name('role-permissions');
Route::post('role-user', [PermissionController::class, 'roleUser'])->name('role-user');

Route::get('/users', [UsersController::class, 'index']);

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
