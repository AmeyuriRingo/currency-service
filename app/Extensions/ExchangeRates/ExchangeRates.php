<?php

namespace App\Extensions\ExchangeRates;

use App\Contracts\ClientInterface;
use App\Contracts\RecommendationStrategy;
use App\Contracts\CurrencyService;
use App\Extensions\Currency\Currency;
use App\Extensions\Rate\Rate;
use DateTimeImmutable;

/**
 * ExchangeRates represents working with exchange rates api.
 */
class ExchangeRates implements CurrencyService
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param Currency $base
     * @param Currency $symbol
     * @return Rate Returns exchangeratesapi response of the latest exchange rate
     */
    public function getLatestRate(Currency $base, Currency $symbol): Rate
    {
        return $this->client->getLatest($base, $symbol);
    }

    /**
     * @param Currency $base
     * @param Currency $symbol
     * @param DateTimeImmutable $date
     * @return Rate Returns exchangeratesapi response of the exchange rate for the selected date
     */
    public function getRateByDate(Currency $base, Currency $symbol, DateTimeImmutable $date): Rate
    {
        return $this->client->getByDate($base, $symbol, $date);
    }

    /**
     * @param Currency $base
     * @param Currency $symbol
     * @param RecommendationStrategy $strategy
     * @param DateTimeImmutable|null $date
     * @return float Return exchangeratesapi response according to date
     */
    public function getRecommendation(Currency $base, Currency $symbol, RecommendationStrategy $strategy, DateTimeImmutable $date = null): float
    {
        return $strategy->execute($base, $symbol, $this->client, $date);
    }

}
