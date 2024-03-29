<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('get-hours/{member_id}/{court_id}/{date}', [BookingController::class, 'getHours']);
Route::resource('bookings', BookingController::class);
Route::get('/search-bookings', [BookingController::class, 'searchBookings'])->name('search-bookings.get');

Route::resource('courts', CourtController::class);
Route::resource('members', MemberController::class);
Route::resource('sports', SportController::class);

require __DIR__.'/auth.php';
