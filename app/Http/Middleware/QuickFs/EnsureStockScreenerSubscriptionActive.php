<?php

namespace App\Http\Middleware\QuickFs;

use App\Models\User;
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
        /** @var User $user */
        $user = $request->user();
        if (!$user->subscribed(config('services.stripe.products.stock-screener.product_id'))) {
            return redirect(config('services.stripe.products.stock-screener.payment_endpoint'));
        }

        if ($user->subscription(config('services.stripe.products.stock-screener.product_id'))
                ->hasIncompletePayment()) {
            return redirect(config('services.stripe.products.stock-screener.payment_endpoint'));
        }

        return $next($request);
    }
}
