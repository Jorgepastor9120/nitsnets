<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AccessTokenController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\CourtController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\SportController;
use App\Http\Controllers\Api\UserController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/oauth/token', [AccessTokenController::class, 'issueToken']);
Route::post('/signup', [AuthController::class, 'signup']);

Route::group([
    'middleware' => ['auth:api']
], function () {
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::put('/bookings/{id}', [BookingController::class, 'update']);
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);
    Route::get('/bookings/{date}', [BookingController::class, 'listBookingByDate']);

    Route::get('/courts', [CourtController::class, 'index']);
    Route::get('/courts/list', [CourtController::class, 'listBookingByDateSportMember']);
    Route::post('/courts', [CourtController::class, 'store']);
    Route::put('/courts/{id}', [CourtController::class, 'update']);
    Route::delete('/courts/{id}', [CourtController::class, 'destroy']);

    Route::get('/members', [MemberController::class, 'index']);
    Route::post('/members', [MemberController::class, 'store']);
    Route::put('/members/{id}', [MemberController::class, 'update']);
    Route::delete('/members/{id}', [MemberController::class, 'destroy']);

    Route::get('/sports', [SportController::class, 'index']);
    Route::post('/sports', [SportController::class, 'store']);
    Route::put('/sports/{id}', [SportController::class, 'update']);
    Route::delete('/sports/{id}', [SportController::class, 'destroy']);

    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});