<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;

class TweakTickerCountryMiddleware
{
    public const MIDDLEWARE_MAPPER = 'tweak-ticker-country';

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->transform($request);

        return $next($request);
    }

    /**
     * Transform the given value.
     *
     * @param Request $request
     * @return void
     */
    protected function transform(Request $request): void
    {
        $input = $request->input();
        $ticker = $input['ticker'] ?? null;

        if(!$ticker) {
            return;
        }

        $request->offsetSet(
            'ticker',
            $this->mutateTickerIfRequired($ticker)
        );
    }

    /**
     * @param string $ticker
     * @return string
     */
    #[Pure] private function mutateTickerIfRequired(string $ticker): string {
        $value = Str::upper($ticker);

        if (Str::endsWith($value, 'MX')) {
            $value = Str::replaceLast('MX', 'MM', $value);
        } elseif (Str::endsWith($value,'UK')) {
            $value = Str::replaceLast('UK', 'LN', $value);
        }

        return $value;
    }
}
