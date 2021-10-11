<?php

namespace App\Http\Controllers;

use App\Business\QuickFs\IQuickFSClient;
use GuzzleHttp\Utils;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class QuickFsController extends Controller
{
    /**
     * @var IQuickFSClient
     */
    private IQuickFSClient $client;

    public function __construct(IQuickFSClient $client)
    {
        $this->client = $client;
//        $this->middleware('ticker');
//        $this->middleware('cache_statements');
    }

    /**
     * @return Response
     */
    public function byTicker(Request $request): Response
    {
        $request->validate([
            'ticker' => [
                'required',
                'regex:/^[a-z0-9]+\.?[a-z0-9]*:[a-z]{2}$/i',
                'max:256',
                'ends_with:US,CA,MX,UK,AU,NZ',
//                new SupportedCompany
            ]
        ]);

        $ticker = $request->get('ticker');

        $body = [
            'data' => [
                'market_cap' => sprintf('QFS(%s,mkt_cap)', $ticker),
                'price' => sprintf('QFS(%s,price)', $ticker),
                'period_end_date' => sprintf('QFS(%s,period_end_date,FY-9:FY)', $ticker),
                'revenue' => sprintf('QFS(%s,revenue,FY-9:FY)', $ticker),
                'net_income' => sprintf('QFS(%s,net_income,FY-9:FY)', $ticker),
                'eps' => sprintf('QFS(%s,eps_diluted,FY-9:FY)', $ticker),
            ]
        ];

        $response = $this->client->multipleMetrics($body);
        $responseBody = Utils::jsonDecode($response->getBody()->getContents());
        $data = $responseBody->data;

        $series = collect();
        for ($i = 0; $i < 10; $i++) {
            $container = [
                'fiscal_end_date' => array_pop($data->period_end_date),
                'revenue' => array_pop($data->revenue),
                'earnings' => array_pop($data->net_income),
                'earnings_per_share' => array_pop($data->eps)
            ];

            $series->prepend($container);
        }

        $data = [
            'ticker' => $ticker,
            'market_cap' => $data->market_cap,
            'price' => $data->price,
            'series' => $series
        ];

        return Inertia::render(
            'Dashboard', ['financials' => $data]
        );
    }
}
