<?php

use App\Http\Controllers\QuickFsController;
use App\Http\Middleware\QuickFs\EnsureStockScreenerSubscriptionActive;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Cashier\Exceptions\IncompletePayment;

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
});

Route::middleware([
    'auth:sanctum',
    'verified',
    EnsureStockScreenerSubscriptionActive::class
])->get('/dashboard',     [
    QuickFsController::class,
    'dashboard'
])->name('dashboard');

Route::middleware([
    'auth:sanctum',
    'verified',
])->get(config('services.stripe.subscriptions.stock-screener.payment_endpoint'), function (Request $request) {
    return Inertia::render('subscribeStockScreener', [
        'intent' => $request->user()->createSetupIntent(),
        'stripe_public_key' => config('services.stripe.key'),
        'product_id' => config('services.stripe.subscriptions.stock-screener.product_id')
    ]);
});

Route::middleware([
    'auth:sanctum',
    'verified',
])->post(config('services.stripe.subscriptions.stock-screener.handle_endpoint'), function (Request $request) {
    try {
        /** @var User $user */
        $user = $request->user();
        $user->newSubscription(
            config('services.stripe.subscriptions.stock-screener.product_id'),
            config('services.stripe.subscriptions.stock-screener.price_id')
        )->create($request->paymentMethodId);

        return redirect()->route('dashboard');
    } catch (IncompletePayment $exception) {
        return redirect()->route(
            'cashier.payment',
            [$exception->payment->id, 'redirect' => route('home')]
        );
    }
});

Route::middleware([
    'auth:sanctum',
    'verified',
])->get('/stripe-billing-portal', function (Request $request) {
    return $request->user()->redirectToBillingPortal(route('dashboard'));
})->name('stripe-billing-portal');
