<?php

namespace App\Contracts;

use App\Extensions\Currency\Currency;
use Carbon\Carbon;

/**
 * CurrencyService represents working with quote currencies.
 */
interface CurrencyService
{
    public function getLatestRate(Currency $currency): Currency;

    public function getRateByDate(Currency $currency, Carbon $date): Currency;

    public function getRecommendation(Currency $currency, RecommendationStrategy $strategy, Carbon $date = null): float;

}
