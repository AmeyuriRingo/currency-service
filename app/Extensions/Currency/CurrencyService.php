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
     * @param string $date
     * @return float
     */
    public function getRate($base, $symbol, $date = ''): float
    {
        return $this->model->getRate($base, $symbol, $date);
    }

    /**
     * Return recommendations according to date
     *
     * @param $base
     * @param $symbol
     * @param $date
     * @return float
     */
    public function getRecommendation($base, $symbol, $date): float
    {
        return $this->model->getRecommendation($base, $symbol, $date);
    }
}
