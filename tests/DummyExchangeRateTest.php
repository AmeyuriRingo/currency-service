<?php

use App\Contracts\ClientInterface;
use App\Extensions\Currency\Currency;
use App\Extensions\ExchangeRates\DummyExchangeRate;
use App\Extensions\ExchangeRates\RecommendationStrategies\ByDateStrategy;
use App\Extensions\ExchangeRates\RecommendationStrategies\LatestStrategy;
use App\Extensions\Rate\Rate;
use Carbon\Carbon;

class DummyExchangeRateTest extends TestCase
{
    protected DummyExchangeRate $dummyExchangeRate;
    protected ClientInterface $client;
    protected Rate $currency;

    protected function setUp(): void
    {
        parent::setUp();

        $currency = new Rate(new Currency('BYN'), new Currency('BRL'), 1.124, new DateTimeImmutable('2015-05-21'));

        $this->currency = $currency;

        $this->dummyExchangeRate = new DummyExchangeRate();

    }

    /**
     * Test dummy get latest rate method.
     */
    public function testDummyGetLatestRate()
    {
        $this->assertEquals(
            $this->currency,
            $this->dummyExchangeRate->getLatestRate($this->currency->getBase(), $this->currency->getSymbol())
        );
    }

    /**
     * Test dummy get rate by date method.
     */
    public function testDummyGetRateByDate()
    {
        $this->assertEquals(
            $this->currency,
            $this->dummyExchangeRate->getRateByDate($this->currency->getBase(), $this->currency->getSymbol(), $this->currency->getDate())
        );
    }

    /**
     * Test dummy get latest recommendation method with date.
     */
    public function testDummyGetLatestRecommendationWithDate()
    {
        $this->assertEquals(
            3.124,
            $this->dummyExchangeRate->getRecommendation($this->currency->getBase(), $this->currency->getSymbol(), new LatestStrategy(), $this->currency->getDate())
        );
    }

    /**
     * Test dummy get latest recommendation method without date.
     */
    public function testDummyGetLatestRecommendationWithoutDate()
    {
        $this->assertEquals(
            3.124,
            $this->dummyExchangeRate->getRecommendation($this->currency->getBase(), $this->currency->getSymbol(), new LatestStrategy())
        );
    }

    /**
     * Test dummy get recommendation by date method.
     */
    public function testDummyGetRecommendationByDate()
    {
        $this->assertEquals(
            3.124,
            $this->dummyExchangeRate->getRecommendation($this->currency->getBase(), $this->currency->getSymbol(), new ByDateStrategy(), $this->currency->getDate())
        );
    }
}
