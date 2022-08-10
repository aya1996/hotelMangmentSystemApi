<?php

use App\Http\Controllers\API\Auth\AdminController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\FacilityController;
use App\Http\Controllers\API\RoomController;
use App\Http\Controllers\API\RoomTypeController;
use App\Models\Booking;
use App\Models\Facility;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('admin/Auth')->group(function () {
    Route::post('/register', [AdminController::class, 'register']);
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/logout', [AdminController::class, 'login']);
});

Route::resource('rooms', RoomController::class);
Route::resource('room-types', RoomTypeController::class);
Route::resource('bookings', BookingController::class);
Route::resource('facilities', FacilityController::class);
