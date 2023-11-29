<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Venue\VenueController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Deal\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/test',function() {
    return 'Hello World ';
});

Route::prefix('/createVenue')->group(function () {
    Route::post('/', [VenueController::class, 'apiStore']); // Create a user

});

Route::post('/login', [LoginController::class, 'loginUser']);
Route::post('end-user/sign-up', [UserController::class, 'apiStore']); // Create profile


Route::middleware(['auth:sanctum'])->group(function () {

    Route::prefix('venue')->group(function () {
        Route::get('/{id}', [VenueController::class, 'apiGetProfile']); // get profile
        Route::post('/update-profile', [VenueController::class, 'apiUpdate']); // Update profile
    });

        Route::post('update-profile', [UserController::class, 'apiUpdate']); // Update profile
        Route::get('end-user/{id}', [UserController::class, 'apiGetProfile']); // get profile
        // View Deals ,dealType = 0 is All Deals,dealType = 1 is currently open
        Route::get('view-deals/{dealType}', [UserController::class, 'viewDeals']);
        Route::get('view-venues/{params}', [UserController::class, 'viewVenues']);
        Route::get('filter-venues/{filterValue}', [UserController::class, 'filterVenues']);
        Route::post('filter-deals', [UserController::class, 'filterDeal']);
        Route::get('delete-account/{userId}', [UserController::class, 'removeAccount']);
        Route::get('deals/{dealId}', [UserController::class, 'viewEachDeal']);
        Route::get('venues/{venueId}', [UserController::class, 'viewEachVenue']);
        Route::get('deal/view-all-categories', [CategoryControllr::class, 'viewCategories']);
        Route::get('forgot-password', [LoginController::class, 'forgotPassword']);


});


