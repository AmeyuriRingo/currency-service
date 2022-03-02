<?php

namespace App\Contracts;

use App\Extensions\Currency\Currency;
use DateTimeImmutable;

interface RecommendationStrategy
{
    public function execute(Currency $base, Currency $symbol, ClientInterface $client, DateTimeImmutable $date = null): float;
}
