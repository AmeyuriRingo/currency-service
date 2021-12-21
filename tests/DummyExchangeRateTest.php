<?php

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
     * Test dummy get rate method.
     */
    public function testDummyGetRate()
    {
        $this->assertEquals(
            3.1212,
            $this->dummyExchangeRate->getRate('BYN', 'EUR')
        );
    }

    /**
     * Test dummy get recommendations method.
     */
    public function testDummyGetRecommendations()
    {
        $this->assertEquals(
            0.123,
            $this->dummyExchangeRate->getRecommendation('BYN', 'EUR', '11-11-2011')
        );
    }
}
