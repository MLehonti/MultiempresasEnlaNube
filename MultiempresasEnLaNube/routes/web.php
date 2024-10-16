<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\BalanceAperturaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PlanCuentasController;
use App\Http\Controllers\SubscriptionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::get('/precio', [SubscriptionController::class, 'index'])->name('subscription.index');
Route::get('/registrar', [SubscriptionController::class, 'registrar'])->name('subscription.registrar');
Route::post('/storeuser', [SubscriptionController::class, 'storeuser'])->name('subscription.storeuser');
Route::get('/pagar', [SubscriptionController::class, 'pagar'])->name('subscription.pagar');
Route::post('/create-payment', [SubscriptionController::class, 'createPayment'])->name('subscription.payment');
Route::get('/list', [SubscriptionController::class, 'listPayments'])->name('subscription.list');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/empresa/create', [EmpresaController::class, 'create'])->name('empresa.create');
    Route::post('/empresa', [EmpresaController::class, 'store'])->name('empresa.store');
    Route::get('/empresa/{empresa}', [EmpresaController::class, 'show'])->name('empresa.show');


    //Ruta para mostrar todos los usruaios del sistema
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    //Ruta para eliminar un usaurio
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');


    //Rutas para los roles
    Route::get('/users/{id}/assign-role', [RoleController::class, 'assignRole'])->name('users.assign-role');
    Route::post('/users/{id}/assign-role', [RoleController::class, 'storeRole'])->name('users.store-role');




    // Ruta para mostrar la lista de todas las empresas
    Route::get('/empresas', [EmpresaController::class, 'index'])->name('empresas.index');



    // Ruta para eliminar la empresa
    Route::delete('/empresa/{empresa}', [EmpresaController::class, 'destroy'])->name('empresa.destroy');

    Route::get('/empresa/{empresa_id}/balance', [BalanceAperturaController::class, 'create'])->name('balance.create');
    Route::post('/balance/store', [BalanceAperturaController::class, 'store'])->name('balance.store');
    Route::get('/empresa/{empresa_id}/balance/show', [BalanceAperturaController::class, 'show'])->name('balance.show');


    //rutas oara el plan

    Route::get('/plan-cuentas', [PlanCuentasController::class, 'index'])->name('plan-cuentas.index');
    Route::get('/plan-cuentas/create', [PlanCuentasController::class, 'create'])->name('plan-cuentas.create');
    Route::post('/plan-cuentas/store', [PlanCuentasController::class, 'store'])->name('plan-cuentas.store');
});

require __DIR__.'/auth.php';
