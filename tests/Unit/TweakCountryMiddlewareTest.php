<?php

namespace Tests\Unit;

use App\Http\Middleware\TweakTickerCountryMiddleware;
use Illuminate\Http\Request;
use Tests\TestCase;

class TweakCountryMiddlewareTest extends TestCase
{
    public function test_tweak_country_invalid_country()
    {
        $request = new Request();

        $request->merge([
            'ticker' => 'GOOGL:JS'
        ]);

        $middleware = new TweakTickerCountryMiddleware();
        $middleware->handle($request, function (Request $request) {});

        $this->assertEquals('GOOGL:JS', $request->input('ticker'));
    }

    public function test_tweak_country_mexico()
    {
        $request = new Request();

        $request->merge([
            'ticker' => 'GOOGL:MX'
        ]);

        $middleware = new TweakTickerCountryMiddleware();
        $middleware->handle($request, function (Request $request) {});

        $this->assertEquals('GOOGL:MM', $request->input('ticker'));
    }

    public function test_tweak_country_united_kingdom()
    {
        $request = new Request();

        $request->merge([
            'ticker' => 'RIO:UK'
        ]);

        $middleware = new TweakTickerCountryMiddleware();
        $middleware->handle($request, function (Request $request) {});

        $this->assertEquals('RIO:LN', $request->input('ticker'));
    }
}
