<?php

namespace App\Extensions\ExchangeRates;

use App\Contracts\ClientInterface;
use App\Contracts\Currency;
use App\Enums\StrategiesEnum;
use Exception;

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
     * @param $base
     * @param $symbol
     * @return float Returns exchangeratesapi response of the latest exchange rate
     */
    public function getLatestRate($base, $symbol): float
    {
        return $this->client->getLatest($base, $symbol);
    }

    /**
     * @param $base
     * @param $symbol
     * @param string $date
     * @return float Returns exchangeratesapi response of the exchange rate for the selected date
     */
    public function getRateByDate($base, $symbol, $date): float
    {
        return $this->client->getByDate($base, $symbol, $date);
    }

    /**
     * Return exchangeratesapi response according to date
     *
     * @param $base
     * @param $symbol
     * @param string $date
     * @param $strategy
     * @return float
     * @throws Exception
     */
    public function getRecommendation($base, $symbol, $strategy, $date = ''): float
    {

        if ($strategy === StrategiesEnum::LATEST) {
            $rate = $this->client->getLatest($base, $symbol);

            return $rate > 1.5 ? -$rate : $rate;
        } else if ($strategy === StrategiesEnum::BY_DATE) {
            $response = $this->client->getRatesByDate($base, $symbol, $date);

            return round(($response['endRate'] - $response['startRate']), 6);
        } else {
            throw new Exception('Undefined strategy!');
        }
    }

}
