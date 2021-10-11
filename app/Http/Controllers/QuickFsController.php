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
//                'period_end_date' => sprintf('QFS(%s,period_end_date,FY-9:FY)', $ticker),
                'price' => sprintf('QFS(%s,price)', $ticker),
                'market_cap' => sprintf('QFS(%s,mkt_cap)', $ticker),
//                'revenue' => sprintf('QFS(%s,revenue,FY-9:FY)', $ticker),
//                'capex' => sprintf('QFS(%s,capex,FY-9:FY)', $ticker),
//                'operating_cash_flow' => sprintf('QFS(%s,cf_cfo,FY-9:FY)', $ticker),
//                'net_income' => sprintf('QFS(%s,net_income,FY-9:FY)', $ticker),
//                'eps' => sprintf('QFS(%s,eps_diluted,FY-9:FY)', $ticker),
            ]
        ];

        $response = $this->client->multipleMetrics($body);
        $responseBody = Utils::jsonDecode($response->getBody()->getContents());
        $data = $responseBody->data;

        $statements = collect();
//        $fallback = 'N/A';
//        for ($i = 0; $i < 10; $i++) {
//            $container = [
//                'fiscal_end_date' => array_pop($data->period_end_date) ?? $fallback,
//                'cash_flow_statement' => [
//                    'operating_cash_flow' => array_pop($data->operating_cash_flow) ?? $fallback,
//                    'capex' => array_pop($data->capex) ?? $fallback
//                ],
//                'income_statement' => [
//                    'revenue' => array_pop($data->revenue) ?? $fallback,
//                    'net_income' => array_pop($data->net_income) ?? $fallback,
//                    'earnings_per_share' => array_pop($data->eps) ?? $fallback
//                ],
//                'balance_sheet' => [
//                    'equity' => array_pop($data->equity) ?? $fallback
//                ]
//            ];
//
//            $statements->prepend($container);
//        }

        $data = [
            'metadata' => [
                'ticker' => $ticker,
                'market_cap' => $data->market_cap,
                'price' => $data->price,
            ],
            'statements' => $statements->all()
        ];

        return Inertia::render(
            'Dashboard', ['data' => $data]
        );
    }
}
