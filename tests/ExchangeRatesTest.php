<?php

use App\Extensions\ExchangeRates\ExchangeRates;
use App\Extensions\RateClient\RateClient;
use GuzzleHttp\Exception\GuzzleException;

class ExchangeRatesTest extends TestCase
{
    /**
     * Test get rate method.
     *
     * @return void
     */
    public function testGetRate()
    {
        $clientMock = $this->createMock(RateClient::class);
        $clientMock->method('getLatest')->willReturn(12.0);
        $rate = new ExchangeRates($clientMock);
        $this->assertEquals(
            12.0,
            $rate->getRate('BYN', 'BRL')
        );
    }

    /**
     * Test get recommendations method.
     *
     * @return void
     */
    public function testGetRecommendations()
    {
        $clientMock = $this->createMock(RateClient::class);
        $clientMock->method('getRecommendation')->willReturn(6.0);
        $rate = new ExchangeRates($clientMock);
        $this->assertEquals(
            6.0,
            $rate->getRecommendation('BYN', 'BRL', '11-11-2011')
        );
    }

}
