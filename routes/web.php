<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GiftCardController;

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

Route::get('/payment', function () {
    return view('payment'); // Assuming 'payment.blade.php' is your view file
});

// Route to process the payment
Route::post('/payment', [GiftCardController::class, 'validateGiftCard'])->name('payment');
Route::post('/applyPayment', [GiftCardController::class, 'applyPaymentGiftCard'])->name('applyPayment');


Route::get('/', function () {
    return view('welcome');
});
