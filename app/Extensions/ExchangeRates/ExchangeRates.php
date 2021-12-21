<?php

namespace App\Extensions\ExchangeRates;

use App\Contracts\ClientInterface;
use App\Contracts\Currency;

/**
 * ExchangeRates represents working with exchange rates api.
 */
class ExchangeRates implements Currency
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Returns exchangeratesapi response of the exchange rate
     *
     * @param $base
     * @param $symbol
     * @param string $date
     * @return mixed|object|string
     */
    public function getRate($base, $symbol, $date = ''): float
    {
        return $this->client->getLatest($base, $symbol);
    }

    /**
     * Return exchangeratesapi response according to date
     *
     * @param $base
     * @param string $symbol
     * @param $date
     * @return float
     */
    public function getRecommendation($base, $symbol, $date): float
    {
        return $this->client->getRecommendation($base, $symbol, $date);
    }

}
