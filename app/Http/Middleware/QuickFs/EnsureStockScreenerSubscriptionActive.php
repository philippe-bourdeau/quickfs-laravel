<?php

namespace App\Http\Middleware\QuickFs;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
        /** @var User $user */
        $user = $request->user();
        if (!$user->subscribed(config('services.stripe.products.stock-screener.product_id'))) {
            return Inertia::location('/subscription');
        }

        if ($user->subscription(config('services.stripe.products.stock-screener.product_id'))
            ->hasIncompletePayment()) {
            return Inertia::location('/subscription');
        }

        return $next($request);
    }
}
