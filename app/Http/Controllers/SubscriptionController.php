<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class SubscriptionController extends Controller
{
    public function __invoke(Request $request)
    {
        $checkout = $request->user()
            ->newSubscription(
                config('services.stripe.products.stock-screener.product_id'),
                config('services.stripe.products.stock-screener.price_id')
            )
            ->checkout();

        return Inertia::render('Subscription', [
            'stripeKey' => config('services.stripe.key'),
            'sessionId' => $checkout->id
        ]);
    }
}
