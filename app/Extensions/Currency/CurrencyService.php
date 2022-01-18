<?php

namespace App\Extensions\Currency;

use App\Contracts\Currency;

/**
 * CurrencyService represents working with quote currencies.
 */
class CurrencyService implements Currency
{
    private Currency $model;

    public function __construct(Currency $model)
    {
        $this->model = $model;
    }

    /**
     * Returns the list of the latest exchange rates
     *
     * @param $base
     * @param $symbol
     * @return float
     */
    public function getLatestRate($base, $symbol): float
    {
        return $this->model->getLatestRate($base, $symbol);
    }

    /**
     * Returns exchangeratesapi response of the exchange rate
     *
     * @param $base
     * @param $symbol
     * @param string $date
     * @return float
     */
    public function getRateByDate($base, $symbol, $date): float
    {
        return $this->model->getRateByDate($base, $symbol, $date);
    }

    /**
     * Return recommendations according to date
     *
     * @param $base
     * @param $symbol
     * @param $date
     * @param $strategy
     * @return float
     */
    public function getRecommendation($base, $symbol, $strategy, $date = ''): float
    {
        return $this->model->getRecommendation($base, $symbol, $strategy, $date);
    }
}
