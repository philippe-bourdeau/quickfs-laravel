<?php

namespace App\Http\Controllers;

use App\Business\QuickFs\Summary;
use App\Http\Middleware\TweakTickerCountryMiddleware;
use App\Validation\QuickFsSupportedCompanyRule;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class QuickFsController extends Controller
{
    public function __construct()
    {
        $this->middleware(TweakTickerCountryMiddleware::MIDDLEWARE_MAPPER);
    }

    public function dashboard(Request $request): Response
    {
        $ticker = $request->get('ticker');
        if ($ticker) {
            $request->validate(
                [
                    'ticker' => [
                        'required',
                        'regex:/^[a-z0-9]{1,5}:[a-z]{2}$/i',
                        'max:7',
                        'ends_with:US,CA,AU,NZ,MX,UK,' /** @see TweakTickerCountryMiddleware */,
                        new QuickFsSupportedCompanyRule
                    ]
                ]
            );
        }

        $summary = $ticker
            ? Summary::fromTicker($ticker)
            : [];

        return Inertia::render(
            'Dashboard',
            [
                'summary' => fn() => $summary
            ]
        );
    }
}
