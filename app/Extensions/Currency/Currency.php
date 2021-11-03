<?php

namespace App\Extensions\Currency;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Enums\CurrenciesEnum;

/**
 * Currency represents working with quote currencies.
 */
class Currency
{
    /**
     * Returns the list of the latest exchange rates
     *
     * @param string $symbols
     * @return mixed|object|string
     */
    public static function getList($symbols = '') {
        $uri = '/v1/latest?access_key='. env('CURRENCY_TOKEN');
        if (!empty($symbols)) $uri = self::getUriWithSymbols($symbols, $uri);
        if (isset($uri->error)) return $uri;
        return self::client('http://api.exchangeratesapi.io', 'GET', $uri);;
    }

    /**
     * Return recommendations according to date
     *
     * @param int $startDate
     * @param int $endDate
     * @param string $symbols
     * @return array|mixed|object|object[]|string
     */
    public static function getRecommendations($startDate = 0, $endDate = 0, $symbols = '') {
        $startUri = '/v1/'. $startDate .'?access_key=' . env('CURRENCY_TOKEN');
        $endUri = '/v1/' . $endDate . '?access_key=' .  env('CURRENCY_TOKEN');
        if (!empty($symbols)) {
            $startUri = self::getUriWithSymbols($symbols, $startUri);
            $endUri = self::getUriWithSymbols($symbols, $endUri);
        }

        if (isset($startUri->error) || isset($endUri->error)) return $startUri;

        $startResponse = self::client('http://api.exchangeratesapi.io', 'GET', $startUri);
        $endResponse =  self::client('http://api.exchangeratesapi.io', 'GET', $endUri);

        if (isset($startResponse->error)) return $startResponse;
        if (isset($endResponse->error)) return $endResponse;

        foreach ($startResponse->rates as $startCurrency => $startRate) {
            foreach ($endResponse->rates as $endCurrency => $endRate) {
                if ($startCurrency === $endCurrency) {
                    $endResponse->rates->$endCurrency = ['rate' => $endRate, 'difference' => round($endRate - $startRate, 6)];
                }
            }
        }
        return ['start' => $startResponse, 'end' => $endResponse];
    }

    /**
     * Generates response according to given data
     *
     * @param $baseUri
     * @param $method
     * @param $uri
     * @return mixed
     * @throws GuzzleException
     */
    protected static function client($baseUri, $method, $uri) {
        $client = new Client(['base_uri' => $baseUri]);
        try {
            $response = $client->request($method, $uri);
            return json_decode($response->getBody()->getContents());
        } catch (\Exception $e)
        {
            return (object) ['error' => $e->getMessage()];
        }
    }

    /**
     * Generates uri according to given currencies
     *
     * @param $symbols
     * @param $uri
     * @return mixed|object|string
     */
    protected static function getUriWithSymbols($symbols, $uri) {
        $symbols = explode( ',', $symbols );
        $currencies_list = CurrenciesEnum::toArray();
        foreach ($symbols as $key => $symbol) {
            if (!empty($currencies_list[trim($symbol)])) {
                $uri = $key === 0 ? $uri .'&symbols=' . trim($symbol) : $uri . ',' . trim($symbol);
            } else {
                return (object) ['error' => 'Incorrect currency: ' . trim($symbol)];
            }
        }
        return $uri;
    }
}
