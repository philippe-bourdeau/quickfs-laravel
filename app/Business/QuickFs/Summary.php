<?php

namespace App\Business\QuickFs;

use GuzzleHttp\Utils;
use JetBrains\PhpStorm\ArrayShape;

class Summary
{
    /**
     * Get formatted summary
     *
     * @param string $ticker
     * @return array{ticker:string, currency: string, name: string, market_cap: int, price:float, series: array}
     */
    #[ArrayShape([
        'ticker' => "string",
        'currency' => "string",
        'name' => "string",
        'market_cap' => "int",
        'price' => "float",
        'series' => "array"])
    ]
    public static function fromTicker(string $ticker): array
    {
        $response = app(IQuickFSClient::class)->summary($ticker);
        $responseBody = Utils::jsonDecode($response->getBody()->getContents());
        $data = $responseBody->data;

        $series = [];
        for ($i = 0; $i < 10; $i++) {
            $series[array_pop($data->period_end_date)] = [
                'revenue' => array_pop($data->revenue),
                'earnings' => array_pop($data->earnings),
                'earnings_per_share' => array_pop($data->earnings_per_share),
                'dividends' => array_pop($data->dividends)
            ];
        }

        return [
            'ticker' => $ticker,
            'currency' => $data->currency,
            'name' => $data->name,
            'market_cap' => $data->market_cap,
            'price' => $data->price,
            'series' => $series
        ];
    }
}
