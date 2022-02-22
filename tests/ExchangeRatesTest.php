<?php

use App\Extensions\Currency\Currency;
use App\Extensions\ExchangeRates\ExchangeRates;
use App\Extensions\ExchangeRates\RecommendationStrategies\ByDateStrategy;
use App\Extensions\ExchangeRates\RecommendationStrategies\LatestStrategy;
use App\Extensions\RateClient\RateClient;
use Carbon\Carbon;

class ExchangeRatesTest extends TestCase
{
    /**
     * Test get latest rate method.
     *
     * @return void
     */
    public function testGetLatestRate()
    {
        $currency = new Currency('BYN', 'BRL');
        $currency->setPrice(1.124);
        $currency->setDate(Carbon::createFromFormat('Y-m-d H', '2015-05-21 22'));

        $clientMock = $this->createMock(RateClient::class);
        $clientMock->method('getLatest')->with($currency)->willReturn($currency);
        $exchangeRate = new ExchangeRates($clientMock);

        $this->assertEquals(
            $currency,
            $exchangeRate->getLatestRate($currency)
        );
    }

    /**
     * Test get rate by date method.
     *
     * @return void
     * @throws Exception
     */
    public function testGetRateByDate()
    {
        $currency = new Currency('BYN', 'BRL');
        $currency->setPrice(1.124);
        $currency->setDate(Carbon::createFromFormat('Y-m-d H', '2015-05-21 22'));

        $clientMock = $this->createMock(RateClient::class);
        $clientMock->method('getByDate')->with($currency, $currency->getDate())->willReturn($currency);
        $exchangeRate = new ExchangeRates($clientMock);

        $this->assertEquals(
            $currency,
            $exchangeRate->getRateByDate($currency, $currency->getDate())
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
        $currency = new Currency('BYN', 'BRL');
        $currency->setPrice(1.124);
        $currency->setDate(Carbon::createFromFormat('Y-m-d H', '2015-05-21 22'));

        $clientMock = $this->createMock(RateClient::class);
        $clientMock->method('getLatest')->with($currency)->willReturn($currency);
        $exchangeRate = new ExchangeRates($clientMock);

        $this->assertEquals(
            $currency->getPrice(),
            $exchangeRate->getRecommendation($currency, new LatestStrategy(), $currency->getDate())
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
        $currency = new Currency('BYN', 'BRL');
        $currency->setPrice(1.124);
        $currency->setDate(Carbon::createFromFormat('Y-m-d H', '2015-05-21 22'));

        $clientMock = $this->createMock(RateClient::class);
        $clientMock->method('getLatest')->with($currency)->willReturn($currency);
        $exchangeRate = new ExchangeRates($clientMock);

        $this->assertEquals(
            $currency->getPrice(),
            $exchangeRate->getRecommendation($currency, new LatestStrategy())
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

        $currency = new Currency('BYN', 'BRL');
        $currency->setPrice(1.124);
        $currency->setDate(Carbon::createFromFormat('Y-m-d', '2015-05-21'));

        $date = date('Y-m-d', strtotime($currency->getDate() . '-1 month'));
        $startDate = Carbon::createFromFormat('Y-m-d', $date);

        $clientMock = $this->createMock(RateClient::class);
        $clientMock
            ->method('getByDate')
            ->withConsecutive(
                [$currency, $currency->getDate()],
                [$currency, $startDate])
            ->willReturn($currency);

        $rate = new ExchangeRates($clientMock);

        $this->assertEquals(
            0,
            $rate->getRecommendation($currency, new ByDateStrategy(), $currency->getDate())
        );
    }

}
