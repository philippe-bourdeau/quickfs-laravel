<?php

namespace Tests\Unit\Validation;

use App\Business\QuickFs\IQuickFSClient;
use App\Validation\QuickFsSupportedCompanyRule;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Validator;
use Mockery\MockInterface;
use Tests\TestCase;

class SupportedCompanyRuleTest extends TestCase
{
    public function test_supported_company_success()
    {
        $this->mock(IQuickFSClient::class, function (MockInterface $mock) {
            $mock->shouldReceive('singleMetric')
                ->andReturn(
                    new Response(
                        200,
                        [],
                        '{"data": 144.61}'
                    )
                );
        });

        $fails = Validator::make(
            [
                'ticker' => 'IBM:US'
            ],
            [
                'ticker' => new QuickFsSupportedCompanyRule
            ]
        )->fails();

        $this->assertFalse($fails);
    }

    public function test_supported_company_fails()
    {
        $this->mock(IQuickFSClient::class, function (MockInterface $mock) {
            $mock->shouldReceive('singleMetric')
                ->andReturn(
                    new Response(
                        207,
                        [],
                        '{
    "data": [
        "UnsupportedCompanyError: BOGUSDOTCOM"
    ],
    "errors": {
        "status": 404,
        "error": "UnsupportedCompanyError",
        "description": "The company you requested is not supported.",
        "message": "We were unable to find the symbol you requested: BOGUSDOTCOM"
    }
}'
                    )
                );
        });

        $fails = Validator::make(
            [
                'ticker' => 'IBM:US'
            ],
            [
                'ticker' => new QuickFsSupportedCompanyRule
            ]
        )->fails();

        $this->assertTrue($fails);
    }
}
