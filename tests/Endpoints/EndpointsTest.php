<?php

namespace Tests\Endpoints;

use App\Business\QuickFs\IQuickFSClient;
use GuzzleHttp\Psr7\Response;
use Inertia\Testing\Assert;
use Mockery\MockInterface;
use Tests\TestCase;

class EndpointsTest extends TestCase
{
    public function test_summary()
    {
        $this->withoutMiddleware();
        $this->followRedirects = true;

        $this->mock(IQuickFSClient::class, function (MockInterface $mock) {
            $mock->shouldReceive('singleMetric')
                ->andReturn(
                    new Response(
                        200,
                        [],
                        '{"data": 323.77}'
                    ));


            $summary = <<<END
{"data":{"market_cap":911524,"price":323.77,"currency":"USD","name":"Facebook Inc","period_end_date":["2011-12","2012-12","2013-12","2014-12","2015-12","2016-12","2017-12","2018-12","2019-12","2020-12"],"revenue":[3711000000,5089000000,7872000000,12466000000,17928000000,27638000000,40653000000,55838000000,70697000000,85965000000],"earnings":[1000000000,53000000,1500000000,2940000000,3688000000,10217000000,15934000000,22112000000,18485000000,29146000000],"earnings_per_share":[0.31,0.02,0.62,1.12,1.31,3.56,5.49,7.65,6.48,10.22],"dividends":[0,0,0,0,0,0,0,0,0,0]}}
END;

            $response = new Response(
                200,
                [],
                $summary
            );

            $mock->shouldReceive('multipleMetrics')
                ->andReturn($response);

            $mock->shouldReceive('summary')
                ->andReturn($response);
        });

        $this->get('/');
        $this->get('/dashboard?ticker=FB:US')
        ->assertInertia(fn (Assert $page) => $page
            ->component('Dashboard')
            ->has('summary', fn (Assert $page) => $page
                ->where('ticker', 'FB:US')
                ->where('currency', 'USD')
                ->where('market_cap', 911524)
                ->where('price', 323.77)
                ->where('name', 'Facebook Inc')
                ->where('series', [
                    '2011-12' => [
                        'dividends' => 0,
                        'earnings' => 1000000000,
                        'earnings_per_share' => 0.31,
                        'revenue' => 3711000000
                    ],
                    '2012-12' => [
                        'dividends' => 0,
                        'earnings' => 53000000,
                        'earnings_per_share' => 0.02,
                        'revenue' => 5089000000
                    ],
                    '2013-12' => [
                        'dividends' => 0,
                        'earnings' => 1500000000,
                        'earnings_per_share' => 0.62,
                        'revenue' => 7872000000
                    ],
                    '2014-12' => [
                        'dividends' => 0,
                        'earnings' => 2940000000,
                        'earnings_per_share' => 1.12,
                        'revenue' => 12466000000
                    ],
                    '2015-12' => [
                        'dividends' => 0,
                        'earnings' => 3688000000,
                        'earnings_per_share' => 1.31,
                        'revenue' => 17928000000
                    ],
                    '2016-12' => [
                        'dividends' => 0,
                        'earnings' => 10217000000,
                        'earnings_per_share' => 3.56,
                        'revenue' => 27638000000
                    ],
                    '2017-12' => [
                        'dividends' => 0,
                        'earnings' => 15934000000,
                        'earnings_per_share' => 5.49,
                        'revenue' => 40653000000
                    ],
                    '2018-12' => [
                        'dividends' => 0,
                        'earnings' => 22112000000,
                        'earnings_per_share' => 7.65,
                        'revenue' => 55838000000
                    ],
                    '2019-12' => [
                        'dividends' => 0,
                        'earnings' => 18485000000,
                        'earnings_per_share' => 6.48,
                        'revenue' => 70697000000
                    ],
                    '2020-12' => [
                        'dividends' => 0,
                        'earnings' => 29146000000,
                        'earnings_per_share' => 10.22,
                        'revenue' => 85965000000
                    ]
                ])
            )
        );
    }

    public function test_invalid_ticker()
    {
        $this->withoutMiddleware();
        $this->followRedirects = true;

        $this->mock(IQuickFSClient::class, function (MockInterface $mock) {
            $mock->shouldReceive('singleMetric')
                ->andReturn(
                    new Response(
                        200,
                        [],
                        '{"data": 323.77}'
                    ));


            $summary = <<<END
{"data":{"market_cap":911524,"price":323.77,"currency":"USD","name":"Facebook Inc","period_end_date":["2011-12","2012-12","2013-12","2014-12","2015-12","2016-12","2017-12","2018-12","2019-12","2020-12"],"revenue":[3711000000,5089000000,7872000000,12466000000,17928000000,27638000000,40653000000,55838000000,70697000000,85965000000],"earnings":[1000000000,53000000,1500000000,2940000000,3688000000,10217000000,15934000000,22112000000,18485000000,29146000000],"earnings_per_share":[0.31,0.02,0.62,1.12,1.31,3.56,5.49,7.65,6.48,10.22],"dividends":[0,0,0,0,0,0,0,0,0,0]}}
END;

            $response = new Response(
                200,
                [],
                $summary
            );

            $mock->shouldReceive('multipleMetrics')
                ->andReturn($response);

            $mock->shouldReceive('summary')
                ->andReturn($response);
        });

        $this->get('/');
        $this->get('/dashboard?ticker=asdfasdfasdfasdf')
            ->assertRedirect(env('APP_URL'))
            ->assertInertia(fn (Assert $page) => $page
                ->component('Dashboard')
                ->has('errors', fn (Assert $page) => $page
                ->where('ticker', 'asdfasdf'))
                ->has('summary', fn (Assert $page) => $page
                ));
    }
}
