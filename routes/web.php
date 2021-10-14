<?php

use Illuminate\Support\Facades\Route;
use Marcosorozco\Catalogs\Http\Controllers\Catalog\CatalogController;

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

Route::prefix('catalogs')
    ->name('catalogs.')
    ->group(
        function () {
            Route::get('{catalog_code}/', [CatalogController::class, 'index'])->name('index');
            Route::post('{catalog_code}/', [CatalogController::class, 'store'])->name('store');
            Route::get('{catalog_code}/create', [CatalogController::class, 'create'])->name('create');
            Route::get('{catalog_code}/{id}', [CatalogController::class, 'show'])->name('show');

            Route::match(
                ['PUT', 'PATCH'],
                '{catalog_code}/{id}',
                [CatalogController::class, 'update']
            )->name('update');

            Route::delete('{catalog_code}/{id}', [CatalogController::class, 'destroy'])->name('destroy');

            Route::delete('{catalog_code}/{id}/restore', [CatalogController::class, 'restore'])->name('restore');

            Route::match(
                ['GET', 'HEAD'],
                '{catalog_code}/{id}/edit',
                [CatalogController::class, 'edit']
            )->name('edit');
        }
    );
