<?php

namespace App\Extensions\RateClient;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Contracts\ClientInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * RateClient represents working with fetching requests.
 */
 class RateClient implements ClientInterface
{

     private string $token;

     public function __construct(string $token)
     {
         $this->token = $token;
     }

     /**
      * Generates response according to given data
      *
      * @param $baseUri
      * @param $method
      * @param $uri
      * @return JsonResponse|mixed
      */
     public function fetch($baseUri, $method, $uri)
     {
         $client = new Client(['base_uri' => $baseUri]);
         try {
             $response = $client->request($method, $uri);
             return json_decode($response->getBody()->getContents());
         } catch (\Throwable $e) {
             report($e);
             return false;
         }
     }

     /**
      * @param $base
      * @param $symbol
      * @return mixed
      */
    public function getLatest($base, $symbol): float {

        $uri = '/v1/latest?access_key=' . $this->token . '&symbols=' . $symbol;
        $fetch = $this->fetch('http://api.exchangeratesapi.io', 'GET', $uri);

        if ($fetch) {
            return $fetch->rates->$symbol;
        } else {
            return false;
        }
    }

     /**
      * @param $base
      * @param $symbol
      * @param $date
      * @return float
      */
    public function getRecommendation($base, $symbol, $date): float {
        $startDate = date('Y-m-d', strtotime($date . '-1 month'));

        $startUri = '/v1/' . $startDate . '?access_key=' . $this->token . '&symbols=' . $symbol;
        $endUri = '/v1/' . $date . '?access_key=' . $this->token . '&symbols=' . $symbol;

        $startRate = $this->fetch('http://api.exchangeratesapi.io', 'GET', $startUri)->rates->$symbol;
        $endRate = $this->fetch('http://api.exchangeratesapi.io', 'GET', $endUri)->rates->$symbol;

        if ($startRate && $endRate) {
            return round(($endRate - $startRate), 6);
        } else {
            return false;
        }
    }

}
