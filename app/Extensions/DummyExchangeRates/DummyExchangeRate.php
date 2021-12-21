<?php

namespace App\Extensions\DummyExchangeRates;

use GuzzleHttp\Exception\GuzzleException;
use App\Contracts\Currency;

/**
 * ExchangeRates represents working with exchange rates api.
 */
class DummyExchangeRate implements Currency
{

    /**
     * Returns exchangeratesapi response of the latest exchange rates
     *
     * @param $base
     * @param $symbol
     * @param string $date
     * @return mixed|object|string
     */
    public function getRate($base, $symbol, $date = ''): float
    {
        return 3.1212;
    }

    /**
     * Return exchangeratesapi response according to date
     *
     * @param string $startDate
     * @param string $endDate
     * @param string $symbol
     * @return array|object[]
     */
    public function getRecommendation($base, $symbol, $date): float
    {
        return 0.123;
    }

}
