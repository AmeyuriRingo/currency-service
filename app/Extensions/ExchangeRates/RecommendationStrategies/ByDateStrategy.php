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
class ByDateStrategy implements RecommendationStrategy
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
        $startDate = $date->sub(new \DateInterval('P1M'));

        $startResponse = $client->getByDate($base, $symbol, $date);
        $endResponse = $client->getByDate($base, $symbol, $startDate);

        if (!empty($startResponse) && !empty($endResponse)) {
            return round(($endResponse->getPrice() - $startResponse->getPrice()), 6);
        } else {
            throw new Exception('Unable to get rate!');
        }
    }
}