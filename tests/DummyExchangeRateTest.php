<?php

use App\Contracts\ClientInterface;
use App\Extensions\Currency\Currency;
use App\Extensions\ExchangeRates\DummyExchangeRate;
use App\Extensions\ExchangeRates\RecommendationStrategies\ByDateStrategy;
use App\Extensions\ExchangeRates\RecommendationStrategies\LatestStrategy;
use App\Extensions\RateClient\RateClient;
use Carbon\Carbon;

class DummyExchangeRateTest extends TestCase
{
    protected DummyExchangeRate $dummyExchangeRate;
    protected ClientInterface $client;
    protected Currency $currency;

    protected function setUp(): void
    {
        parent::setUp();

        $currency = new Currency('BYN', 'BRL');
        $currency->setPrice(1.124);
        $currency->setDate(Carbon::createFromFormat('Y-m-d', '2015-05-21'));

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
            $this->dummyExchangeRate->getLatestRate($this->currency)
        );
    }

    /**
     * Test dummy get rate by date method.
     */
    public function testDummyGetRateByDate()
    {
        $this->assertEquals(
            $this->currency,
            $this->dummyExchangeRate->getRateByDate($this->currency, $this->currency->getDate())
        );
    }

    /**
     * Test dummy get latest recommendation method with date.
     */
    public function testDummyGetLatestRecommendationWithDate()
    {
        $this->assertEquals(
            3.124,
            $this->dummyExchangeRate->getRecommendation($this->currency, new LatestStrategy(), $this->currency->getDate())
        );
    }

    /**
     * Test dummy get latest recommendation method without date.
     */
    public function testDummyGetLatestRecommendationWithoutDate()
    {
        $this->assertEquals(
            3.124,
            $this->dummyExchangeRate->getRecommendation($this->currency, new LatestStrategy())
        );
    }

    /**
     * Test dummy get recommendation by date method.
     */
    public function testDummyGetRecommendationByDate()
    {
        $this->assertEquals(
            3.124,
            $this->dummyExchangeRate->getRecommendation($this->currency, new ByDateStrategy(), $this->currency->getDate())
        );
    }
}
