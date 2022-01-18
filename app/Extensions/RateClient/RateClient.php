<?php

namespace App\Extensions\RateClient;

use Exception;
use GuzzleHttp\Client;
use App\Contracts\ClientInterface;
use Illuminate\Support\Facades\Log;

/**
 * RateClient represents working with requests.
 */
 class RateClient implements ClientInterface
{

     private string $token;
     private Client $client;

     public function __construct(string $token, string $baseUri)
     {
         $this->token = $token;
         $this->client = new Client(['base_uri' => $baseUri]);
     }

     /**
      * @param $base
      * @param $symbol
      * @return float Returns latest exchange rate
      * @throws Exception
      */
    public function getLatest($base, $symbol): float {

        $uri = sprintf('/v/latest?access_key=%s&symbols=%s', $this->token, $symbol);

        try {
            $response = $this->client->get($uri);

            $result = json_decode($response->getBody()->getContents(), true);

            if (isset($result['rates'][$symbol])) {
                return $result['rates'][$symbol];
            }
        } catch (\Throwable $e) {
            Log::error($e);
        }

        throw new Exception('Unable to get latest rate!');
    }

     /**
      * @param $base
      * @param $symbol
      * @param $date
      * @return float Returns the exchange rate for the selected date
      * @throws Exception
      */
     public function getByDate($base, $symbol, $date): float {

         $uri = sprintf('/v1/%s?access_key=%s&symbols=%s', $date, $this->token, $symbol);

         try {
             $response = $this->client->get($uri);

             $result = json_decode($response->getBody()->getContents(), true);

             if (isset($result['rates'][$symbol])) {
                 return $result['rates'][$symbol];
             }
         } catch (\Throwable $e) {
             Log::error($e);
         }

         throw new Exception('Unable to get rate by date!');
     }

     /**
      * @param $base
      * @param $symbol
      * @param $date
      * @return array Returns array with the exchange rate for the selected date and for the last month's exchange rate
      * @throws Exception
      */
    public function getRatesByDate($base, $symbol, $date): array {
        $startDate = date('Y-m-d', strtotime($date . '-1 month'));

        $startUri = sprintf('/v1/%s?access_key=%s&symbols=%s', $startDate, $this->token, $symbol);
        $endUri = sprintf('/v1/%s?access_key=%s&symbols=%s', $date, $this->token, $symbol);


        try {
            $startResponse = $this->client->get($startUri);
            $endResponse = $this->client->get($endUri);

            $startResult = json_decode($startResponse->getBody()->getContents(), true);
            $endResult = json_decode($endResponse->getBody()->getContents(), true);

            if (isset($startResult['rates'][$symbol]) && isset($endResult['rates'][$symbol])) {
                return [
                    'startRate' => $startResult['rates'][$symbol],
                    'endRate' => $endResult['rates'][$symbol],
                    ];
            }
        } catch (\Throwable $e) {
            Log::error($e);
        }

        throw new Exception('Unable to get recommendation!');
    }

}
