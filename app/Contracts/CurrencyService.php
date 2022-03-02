<?php

namespace App\Contracts;

use App\Extensions\Currency\Currency;
use App\Extensions\Rate\Rate;
use DateTimeImmutable;

/**
 * CurrencyService represents working with quote currencies.
 */
interface CurrencyService
{
    public function getLatestRate(Currency $base, Currency $symbol): Rate;

    public function getRateByDate(Currency $base, Currency $symbol, DateTimeImmutable $date): Rate;

    public function getRecommendation(Currency $base, Currency $symbol, RecommendationStrategy $strategy, DateTimeImmutable $date = null): float;

}
