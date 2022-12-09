<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\DetailTransactionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () 
{
    return view('welcome');
});

Route::get('/dashboard', function () 
{
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () 
{
    Route::prefix('collections')->group(function () 
    {
        Route::controller(CollectionController::class)->group(function () 
        {
            Route::get('', 'index')->name('collections.index');
            Route::get('list', 'getCollections')->name('collections.list');
            Route::get('create', 'create')->name('collections.create');
            Route::post('store', 'store')->name('collections.store');
            Route::get('show/{id}', 'show')->name('collections.show');
            Route::post('update', 'update')->name('collections.update');
        });
    });

    Route::prefix('transactions')->group(function () 
    {
        Route::controller(TransactionController::class)->group(function () 
        {
            Route::get('', 'index')->name('transactions.index');
            Route::get('list', 'getTransactions')->name('transactions.list');
            Route::get('create', 'create')->name('transactions.create');
            Route::post('store', 'store')->name('transactions.store');
            Route::get('show/{id}', 'show')->name('transactions.show');
        });

        Route::controller(DetailTransactionController::class)->group(function () 
        {
            Route::get('detail/{id}', 'getDetailTransactions')->name('transactions.detail');
            Route::get('edit/{id}', 'edit')->name('transactions.edit');
            Route::post('update', 'update')->name('transactions.update');
        });
    });

    Route::prefix('users')->group(function () 
    {
        Route::controller(UserController::class)->group(function () 
        {
            Route::get('', 'index')->name('users.index');
            Route::get('list', 'getUsers')->name('users.list');
            Route::get('create', 'create')->name('users.create');
            Route::post('store', 'store')->name('users.store');
            Route::get('show/{id}', 'show')->name('users.show');
            Route::post('update', 'update')->name('users.update');
        });
    });
});

require __DIR__.'/auth.php';
