<?php

use App\Enums\StrategiesEnum;
use App\Extensions\ExchangeRates\ExchangeRates;
use App\Extensions\RateClient\RateClient;

class ExchangeRatesTest extends TestCase
{
    /**
     * Test get latest rate method.
     *
     * @return void
     */
    public function testGetLatestRate()
    {
        $clientMock = $this->createMock(RateClient::class);
        $clientMock->method('getLatest')->with($base = 'BYN', $symbol ='BRL')->willReturn($rate = 12.0);
        $exchangeRate = new ExchangeRates($clientMock);
        $this->assertEquals(
            $rate,
            $exchangeRate->getLatestRate($base, $symbol)
        );
    }

    /**
     * Test get rate by date method.
     *
     * @return void
     */
    public function testGetRateByDate()
    {
        $clientMock = $this->createMock(RateClient::class);
        $clientMock->method('getByDate')->with($base = 'BYN', $symbol ='BRL', $date = '11-15-2021')->willReturn($rate = 12.0);
        $exchangeRate = new ExchangeRates($clientMock);
        $this->assertEquals(
            $rate,
            $exchangeRate->getRateByDate($base, $symbol, $date)
        );
    }

    /**
     * Test get latest recommendation strategy with date.
     *
     * @return void
     * @throws Exception
     */
    public function testGetLatestRecommendationWithDate()
    {
        $clientMock = $this->createMock(RateClient::class);
        $clientMock->method('getLatest')->with($base = 'BYN', $symbol ='BRL')->willReturn($rate = 10.1);
        $exchangeRate = new ExchangeRates($clientMock);
        $this->assertEquals(
            $rate,
            $exchangeRate->getRecommendation($base, $symbol, StrategiesEnum::LATEST, '11-11-2011')
        );
    }

    /**
     * Test get latest recommendation strategy without date.
     *
     * @return void
     * @throws Exception
     */
    public function testGetLatestRecommendationWithoutDate()
    {
        $clientMock = $this->createMock(RateClient::class);
        $clientMock->method('getLatest')->with($base = 'BYN', $symbol ='BRL')->willReturn($rate = 14.4);
        $exchangeRate = new ExchangeRates($clientMock);
        $this->assertEquals(
            $rate,
            $exchangeRate->getRecommendation($base, $symbol, StrategiesEnum::LATEST)
        );
    }

    /**
     * Test get recommendation by date strategy.
     *
     * @return void
     * @throws Exception
     */
    public function testGetRecommendationByDate()
    {
        $clientMock = $this->createMock(RateClient::class);
        $clientMock->method('getRatesByDate')->with($base = 'BYN', $symbol ='BRL', $date = '11-15-2021')->willReturn($rates = [
            'startRate' => 6.0,
            'endRate' => 7.0
        ]);
        $rate = new ExchangeRates($clientMock);
        $this->assertEquals(
            round(($rates['endRate'] - $rates['startRate']), 6),
            $rate->getRecommendation($base, $symbol,StrategiesEnum::BY_DATE, $date)
        );
    }

}
