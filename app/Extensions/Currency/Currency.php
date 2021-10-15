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
     * Currency controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Returns the list of the latest exchange rates
     *
     * @return mixed
     */
    public static function getList($base = '', $symbols = '') {
        dd(CurrenciesEnum::BYN());
        $uri = '/v1/latest?access_key=6a4e4f160a7e9f3f2e6beb191e4a5968';
        if ($symbols) $uri = $uri . '&symbols=' . $symbols;
        return self::client('http://api.exchangeratesapi.io', 'GET', $uri);
    }

    /**
     * Return recommendations according to date
     *
     * @throws GuzzleException
     */
    public static function getRecommendations($startDate = 0, $endDate = 0, $symbols = '') {
        $startUri = '/v1/'. $startDate .'?access_key=6a4e4f160a7e9f3f2e6beb191e4a5968';
        $endUri = '/v1/' . $endDate . '?access_key=6a4e4f160a7e9f3f2e6beb191e4a5968';
        if (isset($symbols)) {
            $startUri = $startUri . '&symbols=' . $symbols;
            $endUri = $endUri . '&symbols=' . $symbols;
        };
        $startResponse = self::client('http://api.exchangeratesapi.io', 'GET', $startUri);
        $endResponse =  self::client('http://api.exchangeratesapi.io', 'GET', $endUri);
        foreach ($startResponse->rates as $startCurrency => $startRate) {
            foreach ($endResponse->rates as $endCurrency => $endRate) {
                if ($startCurrency === $endCurrency) {
                    $endResponse->rates->$endCurrency = ['rate' => $endRate, 'difference' => round($startRate - $endRate, 6)];
                }
            }
        }
        return ['start' => $startResponse, 'end' => $endResponse];
    }

    /**
     *
     *
     * @param $baseUri
     * @param $method
     * @param $uri
     * @return mixed
     * @throws GuzzleException
     */
    protected static function client($baseUri, $method, $uri) {
        $client = new Client(['base_uri' => $baseUri]);
        $response = $client->request($method, $uri);
        return json_decode($response->getBody()->getContents());
    }
}
