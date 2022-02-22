<?php

namespace App\Contracts;

use App\Extensions\Currency\Currency;
use Carbon\Carbon;

interface RecommendationStrategy
{
    public function execute(Currency $currency, ClientInterface $client, Carbon $date = null): float;
}
