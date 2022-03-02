<?php

namespace App\Extensions\ExchangeRates;

use App\Contracts\RecommendationStrategy;
use App\Contracts\CurrencyService;
use App\Extensions\Currency\Currency;
use App\Extensions\Rate\Rate;
use DateTimeImmutable;

/**
 * ExchangeRates represents working with exchange rates api.
 */
class DummyExchangeRate implements CurrencyService
{

    private Rate $currency;

    public function __construct()
    {

        $currency = new Rate(new Currency('BYN'), new Currency('BRL'), 1.124, new DateTimeImmutable('2015-05-21'));

        $this->currency = $currency;
    }

    /**
     * @param Currency $base
     * @param Currency $symbol
     * @return Rate Returns exchangeratesapi response of the latest exchange rate
     */
    public function getLatestRate(Currency $base, Currency $symbol): Rate
    {
        return $this->currency;
    }

    /**
     * @param Currency $base
     * @param Currency $symbol
     * @param DateTimeImmutable $date
     * @return Rate Returns exchangeratesapi response of the exchange rate for the selected date
     */
    public function getRateByDate(Currency $base, Currency $symbol, DateTimeImmutable $date): Rate
    {
        return $this->currency;
    }

    /**
     * Return exchangeratesapi response according to date
     *
     * @param Currency $base
     * @param Currency $symbol
     * @param RecommendationStrategy $strategy
     * @param DateTimeImmutable|null $date
     * @return float
     */
    public function getRecommendation(Currency $base, Currency $symbol, RecommendationStrategy $strategy, DateTimeImmutable $date = null): float
    {
        return 3.124;
    }

}
