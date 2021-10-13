<?php

namespace Tests\Endpoints;

use App\Business\QuickFs\IQuickFSClient;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Utils;
use Inertia\Testing\Assert;
use Mockery\MockInterface;
use Tests\TestCase;

class EndpointsTest extends TestCase
{
    public function test_summary()
    {
        $this->mock(IQuickFSClient::class, function (MockInterface $mock) {
            $mockBody = '{"data":{"market_cap":911524,"price":323.77,"currency":"USD","name":"Facebook Inc","period_end_date":["2011-12","2012-12","2013-12","2014-12","2015-12","2016-12","2017-12","2018-12","2019-12","2020-12"],"revenue":[3711000000,5089000000,7872000000,12466000000,17928000000,27638000000,40653000000,55838000000,70697000000,85965000000],"earnings":[1000000000,53000000,1500000000,2940000000,3688000000,10217000000,15934000000,22112000000,18485000000,29146000000],"earnings_per_share":[0.31,0.02,0.62,1.12,1.31,3.56,5.49,7.65,6.48,10.22],"dividends":[0,0,0,0,0,0,0,0,0,0]}}';
            $array = Utils::jsonDecode($mockBody);

            $mock->shouldReceive('multipleMetrics')
                ->andReturn(
                    new Response(
                        200,
                          $array,
                    )
                );
        });

        $this->get('/summary')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Dashboard')
                ->has('summary', fn (Assert $page) => $page
                    ->where('name', 'Facebook')
                    ->where('subject', 'The Laravel Podcast')
                )
            );
    }
}
