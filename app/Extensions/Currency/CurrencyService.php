<?php

namespace App\Extensions\Currency;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Enums\CurrenciesEnum;
use App\Contracts\Currency;

/**
 * CurrencyService represents working with quote currencies.
 */
class CurrencyService implements Currency
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Returns the list of the latest exchange rates
     *
     * @param string $symbols
     * @return mixed|object|string
     * @throws GuzzleException
     */
    public function getList($symbols = '')
    {
        return $this->model->getList($symbols);
    }

    /**
     * Return recommendations according to date
     *
     * @param int $startDate
     * @param int $endDate
     * @param string $symbols
     * @return array|mixed|object|object[]|string
     * @throws GuzzleException
     */
    public function getRecommendations($startDate = 0, $endDate = 0, $symbols = '')
    {
        return $this->model->getRecommendations($startDate, $endDate, $symbols);
    }
}
