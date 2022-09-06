<?php

use App\Http\Controllers\QuickFsController;
use App\Http\Middleware\QuickFs\EnsureStockScreenerSubscriptionActive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Cashier\Billable;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('home');

Route::middleware([
    'auth:sanctum',
    'verified',
    EnsureStockScreenerSubscriptionActive::class
])->get('/dashboard', [
    QuickFsController::class,
    'dashboard'
])->name('dashboard');

Route::get(config('services.stripe.products.stock-screener.checkout'), function (Request $request) {
    /** @var Billable $user */
    $user = $request->user();
    return $user
        ->newSubscription(
            config('services.stripe.products.stock-screener.product_id'),
            config('services.stripe.products.stock-screener.price_id')
        )
        ->checkout([
            'success_url' => route('dashboard'),
            'cancel_url' => route('home'),
        ]);
})->name('checkout');

Route::middleware([
    'auth:sanctum',
    'verified',
])->get('/stripe-billing-portal', function (Request $request) {
    return Inertia::location($request->user()->billingPortalUrl());
})->name('stripe-billing-portal');
