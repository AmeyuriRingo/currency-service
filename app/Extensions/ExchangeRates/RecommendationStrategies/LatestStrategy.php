<?php

namespace App\Extensions\ExchangeRates\RecommendationStrategies;

use App\Contracts\ClientInterface;
use App\Contracts\RecommendationStrategy;
use App\Extensions\Currency\Currency;
use DateTimeImmutable;
use Exception;

/**
 * ExchangeRates represents working with exchange rates api.
 */
class LatestStrategy implements RecommendationStrategy
{
    /**
     * @param Currency $base
     * @param Currency $symbol
     * @param ClientInterface $client
     * @param DateTimeImmutable|null $date
     * @return float
     * @throws Exception
     */
    public function execute(Currency $base, Currency $symbol, ClientInterface $client, DateTimeImmutable $date = null): float {
        $rate = $client->getLatest($base, $symbol)->getPrice();

        if (!empty($rate)) {
            return $rate > 1.5 ? -$rate : $rate;
        } else {
            throw new Exception('Unable to get rate');
        }
    }
}