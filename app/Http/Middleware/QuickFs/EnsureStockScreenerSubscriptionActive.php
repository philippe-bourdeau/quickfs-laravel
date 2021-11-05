<?php

namespace App\Http\Middleware\QuickFs;

use Closure;
use Illuminate\Http\Request;

class EnsureStockScreenerSubscriptionActive
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() && !$request->user()->subscribed(config('services.stripe.subscriptions.stock-screener.product_id'))) {
            return redirect(config('services.stripe.subscriptions.stock-screener.payment_endpoint'));
        }

        return $next($request);
    }
}
