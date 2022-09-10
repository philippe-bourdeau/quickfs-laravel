<?php

use App\Http\Controllers\QuickFsController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Middleware\QuickFs\EnsureStockScreenerSubscriptionActive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/subscription', SubscriptionController::class)
    ->name('subscription');

Route::middleware([
    'auth:sanctum',
    'verified',
])->get('/stripe-billing-portal', function (Request $request) {
    return Inertia::location($request->user()->billingPortalUrl(route('dashboard')));
})->name('stripe-billing-portal');
