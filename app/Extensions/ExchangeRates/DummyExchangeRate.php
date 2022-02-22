<?php

namespace App\Extensions\ExchangeRates;

use App\Contracts\RecommendationStrategy;
use App\Contracts\CurrencyService;
use App\Extensions\Currency\Currency;
use Carbon\Carbon;

/**
 * ExchangeRates represents working with exchange rates api.
 */
class DummyExchangeRate implements CurrencyService
{

    private Currency $currency;

    public function __construct()
    {

        $currency = new Currency('BYN', 'BRL');
        $currency->setPrice(1.124);
        $currency->setDate(Carbon::createFromFormat('Y-m-d', '2015-05-21'));

        $this->currency = $currency;
    }

    /**
     * @param Currency $currency
     * @return Currency Returns exchangeratesapi response of the latest exchange rate
     */
    public function getLatestRate(Currency $currency): Currency
    {
        return $this->currency;
    }

    /**
     * @param Currency $currency
     * @param Carbon $date
     * @return Currency Returns exchangeratesapi response of the exchange rate for the selected date
     */
    public function getRateByDate(Currency $currency, Carbon $date): Currency
    {
        return $this->currency;
    }

    /**
     * Return exchangeratesapi response according to date
     *
     * @param Currency $currency
     * @param RecommendationStrategy $strategy
     * @param Carbon|null $date
     * @return float
     */
    public function getRecommendation(Currency $currency, RecommendationStrategy $strategy, Carbon $date = null): float
    {
        return 3.124;
    }

}
