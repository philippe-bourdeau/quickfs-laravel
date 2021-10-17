<?php


namespace App\Business\QuickFs;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Utils;
use Psr\Http\Message\ResponseInterface;

class QuickFSClient implements IQuickFSClient
{
    /**
     * @var Client
     */
    private Client $client;

    public function __construct(string $authHeader, string $apiKey, string $baseURI)
    {
        $this->client = new Client([
            RequestOptions::HEADERS => [
                'Accept' => 'Application/json',
                'Content-Type' => 'Application/json',
                $authHeader => $apiKey,
            ],
            'base_uri' => $baseURI
        ]);
    }

    /**
     * @param array $body
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function multipleMetrics(array $body): ResponseInterface
    {
        return $this->client->request(
            'POST',
            'v1/data/batch',
            [
                RequestOptions::BODY => Utils::jsonEncode($body)
            ]
        );
    }

    /**
     * @param string $ticker
     * @param string $metric
     * @param string $period
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function singleMetric(string $ticker, string $metric, string $period): ResponseInterface
    {
        return $this->client->request(
            'GET',
            sprintf('v1/data/%s/%s', $ticker, $metric),
            [
                RequestOptions::QUERY => [
                    'period' =>  $period
                ]
            ]
        );
    }

    /**
     *
     * @param string $ticker
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function summary(string $ticker): ResponseInterface
    {
        $body = [
            'data' => [
                'market_cap' => sprintf('QFS(%s,mkt_cap)', $ticker),
                'price' => sprintf('QFS(%s,price)', $ticker),
                'currency' => sprintf('QFS(%s,currency)', $ticker),
                'name' => sprintf('QFS(%s,name)', $ticker),
                'period_end_date' => sprintf('QFS(%s,period_end_date,FY-9:FY)', $ticker),
                'revenue' => sprintf('QFS(%s,revenue,FY-9:FY)', $ticker),
                'earnings' => sprintf('QFS(%s,net_income,FY-9:FY)', $ticker),
                'earnings_per_share' => sprintf('QFS(%s,eps_basic,FY-9:FY)', $ticker),
                'dividends' => sprintf('QFS(%s,dividends,FY-9:FY)', $ticker),
            ]
        ];

        return $this->multipleMetrics($body);
    }
}
