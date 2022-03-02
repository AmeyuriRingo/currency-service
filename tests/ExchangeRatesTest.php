<?php

use App\Extensions\Currency\Currency;
use App\Extensions\ExchangeRates\ExchangeRates;
use App\Extensions\ExchangeRates\RecommendationStrategies\ByDateStrategy;
use App\Extensions\ExchangeRates\RecommendationStrategies\LatestStrategy;
use App\Extensions\Rate\Rate;
use App\Extensions\RateClient\RateClient;

class ExchangeRatesTest extends TestCase
{
    /**
     * Test get latest rate method.
     *
     * @return void
     * @throws Exception
     */
    public function testGetLatestRate()
    {
        $currency = new Rate(new Currency('BYN'), new Currency('BRL'), 1.124, new DateTimeImmutable('2015-05-21'));

        $clientMock = $this->createMock(RateClient::class);
        $clientMock->method('getLatest')->with($currency->getBase(), $currency->getSymbol())->willReturn($currency);
        $exchangeRate = new ExchangeRates($clientMock);

        $this->assertEquals(
            $currency,
            $exchangeRate->getLatestRate($currency->getBase(), $currency->getSymbol())
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
        $currency = new Rate(new Currency('BYN'), new Currency('BRL'), 1.124, new DateTimeImmutable('2015-05-21'));

        $clientMock = $this->createMock(RateClient::class);
        $clientMock->method('getByDate')->with($currency->getBase(), $currency->getSymbol(), $currency->getDate())->willReturn($currency);
        $exchangeRate = new ExchangeRates($clientMock);

        $this->assertEquals(
            $currency,
            $exchangeRate->getRateByDate($currency->getBase(), $currency->getSymbol(), $currency->getDate())
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
        $currency = new Rate(new Currency('BYN'), new Currency('BRL'), 1.124, new DateTimeImmutable('2015-05-21'));

        $clientMock = $this->createMock(RateClient::class);
        $clientMock->method('getLatest')->with($currency->getBase(), $currency->getSymbol())->willReturn($currency);
        $exchangeRate = new ExchangeRates($clientMock);

        $this->assertEquals(
            $currency->getPrice(),
            $exchangeRate->getRecommendation($currency->getBase(), $currency->getSymbol(), new LatestStrategy(), $currency->getDate())
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
        $currency = new Rate(new Currency('BYN'), new Currency('BRL'), 1.124, new DateTimeImmutable('2015-05-21'));

        $clientMock = $this->createMock(RateClient::class);
        $clientMock->method('getLatest')->with($currency->getBase(), $currency->getSymbol())->willReturn($currency);
        $exchangeRate = new ExchangeRates($clientMock);

        $this->assertEquals(
            $currency->getPrice(),
            $exchangeRate->getRecommendation($currency->getBase(), $currency->getSymbol(), new LatestStrategy())
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

        $currency = new Rate(new Currency('BYN'), new Currency('BRL'), 1.124, new DateTimeImmutable('2015-05-21'));

        $startDate = $currency->getDate()->sub(new DateInterval('P1M'));

        $clientMock = $this->createMock(RateClient::class);
        $clientMock
            ->method('getByDate')
            ->withConsecutive(
                [$currency->getBase(), $currency->getSymbol(), $currency->getDate()],
                [$currency->getBase(), $currency->getSymbol(), $startDate])
            ->willReturn($currency);

        $rate = new ExchangeRates($clientMock);

        $this->assertEquals(
            0,
            $rate->getRecommendation($currency->getBase(), $currency->getSymbol(), new ByDateStrategy(), $currency->getDate())
        );
    }

}
