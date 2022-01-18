<?php

use App\Enums\StrategiesEnum;
use App\Extensions\DummyExchangeRates\DummyExchangeRate;

class DummyExchangeRateTest extends TestCase
{
    protected DummyExchangeRate $dummyExchangeRate;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dummyExchangeRate = new DummyExchangeRate();

    }

    /**
     * Test dummy get latest rate method.
     */
    public function testDummyGetLatestRate()
    {
        $this->assertEquals(
            3.124,
            $this->dummyExchangeRate->getLatestRate('BYN', 'EUR')
        );
    }

    /**
     * Test dummy get rate by date method.
     */
    public function testDummyGetRateByDate()
    {
        $this->assertEquals(
            4.567,
            $this->dummyExchangeRate->getRateByDate('BYN', 'EUR', '11-12-2021')
        );
    }

    /**
     * Test dummy get latest recommendation method with date.
     */
    public function testDummyGetLatestRecommendationWithDate()
    {
        $this->assertEquals(
            1.5786,
            $this->dummyExchangeRate->getRecommendation('BYN', 'EUR',StrategiesEnum::LATEST, '11-11-2011')
        );
    }

    /**
     * Test dummy get latest recommendation method without date.
     */
    public function testDummyGetLatestRecommendationWithoutDate()
    {
        $this->assertEquals(
            1.5786,
            $this->dummyExchangeRate->getRecommendation('BYN', 'EUR',StrategiesEnum::LATEST)
        );
    }

    /**
     * Test dummy get recommendation by date method.
     */
    public function testDummyGetRecommendationByDate()
    {
        $this->assertEquals(
            0.5786,
            $this->dummyExchangeRate->getRecommendation('BYN', 'EUR',StrategiesEnum::BY_DATE, '11-11-2011')
        );
    }
}
