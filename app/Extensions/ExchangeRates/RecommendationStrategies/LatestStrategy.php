<?php

namespace App\Extensions\ExchangeRates\RecommendationStrategies;

use App\Contracts\ClientInterface;
use App\Contracts\RecommendationStrategy;
use App\Extensions\Currency\Currency;
use Carbon\Carbon;
use Exception;

/**
 * ExchangeRates represents working with exchange rates api.
 */
class LatestStrategy implements RecommendationStrategy
{
    /**
     * @param Currency $currency
     * @param ClientInterface $client
     * @param Carbon|null $date
     * @return float
     * @throws Exception
     */
    public function execute(Currency $currency, ClientInterface $client, Carbon $date = null): float {
        $rate = $client->getLatest($currency)->getPrice();

        if (!empty($rate)) {
            return $rate > 1.5 ? -$rate : $rate;
        } else {
            throw new Exception('Unable to get rate!');
        }
    }
}