<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Deal\CategoryController;
use App\Http\Controllers\Deal\DealController;
use App\Http\Controllers\Deal\SubCategoryController;
use App\Http\Controllers\Suburb\SuburbController;
use App\Http\Controllers\Venue\VenueController;
use App\Http\Controllers\Product\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Route::get('/', function () {
    return redirect('login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::group(['middleware' => 'admin'], function () {
        Route::resource('venues', VenueController::class)->except('show');
        Route::resource('suburbs', SuburbController::class)->except('show');
        Route::group(['prefix' => 'deal'], function () {
            Route::resource('categories', CategoryController::class)->except('show');
            Route::group(['prefix' => 'categories'], function () {
                Route::resource('sub_categories', SubCategoryController::class)->except('show');
            });
        });
    });
    Route::resource('product', ProductController::class);
    Route::resource('deals', DealController::class);
});

Auth::routes(['register' => false]);

