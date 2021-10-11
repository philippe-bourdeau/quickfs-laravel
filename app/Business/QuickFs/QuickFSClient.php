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
}
