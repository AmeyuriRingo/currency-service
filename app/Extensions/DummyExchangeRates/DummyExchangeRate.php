<?php

namespace App\Extensions\DummyExchangeRates;

use App\Enums\StrategiesEnum;
use App\Contracts\Currency;

/**
 * ExchangeRates represents working with exchange rates api.
 */
class DummyExchangeRate implements Currency
{

    /**
     * @param $base
     * @param $symbol
     * @return float Returns exchangeratesapi response of the latest exchange rate
     */
    public function getLatestRate($base, $symbol): float
    {
        return 3.124;
    }

    /**
     * @param $base
     * @param $symbol
     * @param string $date
     * @return float Returns exchangeratesapi response of the exchange rate for the selected date
     */
    public function getRateByDate($base, $symbol, $date): float
    {
        return 4.567;
    }

    /**
     * Return exchangeratesapi response according to date
     *
     * @param $base
     * @param $symbol
     * @param string $date
     * @param $strategy
     * @return float
     */
    public function getRecommendation($base, $symbol, $strategy, $date = ''): float
    {
        if ($strategy === StrategiesEnum::LATEST) {
            return 1.5786;
        } else if ($strategy === StrategiesEnum::BY_DATE) {
            return 0.5786;
        }
    }

}
