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
class ByDateStrategy implements RecommendationStrategy
{
    /**
     * @param Currency $currency
     * @param ClientInterface $client
     * @param Carbon|null $date
     * @return float
     * @throws Exception
     */
    public function execute(Currency $currency, ClientInterface $client, Carbon $date = null): float {
        $startDate = date('Y-m-d', strtotime($date . '-1 month'));
        $startDate = Carbon::createFromFormat('Y-m-d', $startDate);

        $startResponse = $client->getByDate($currency, $date);
        $endResponse = $client->getByDate($currency, $startDate);

        if (!empty($startResponse) && !empty($endResponse)) {
            return round(($endResponse->getPrice() - $startResponse->getPrice()), 6);
        } else {
            throw new Exception('Unable to get rate!');
        }
    }
}