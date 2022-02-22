<?php

namespace App\Extensions\RateClient;

use App\Extensions\Currency\Currency;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use App\Contracts\ClientInterface;
use Psr\Log\LoggerInterface;

/**
 * RateClient represents working with requests.
 */
 class RateClient implements ClientInterface
{

     private string $token;
     private Client $client;
     private LoggerInterface $logger;

     public function __construct(string $token, string $baseUri, LoggerInterface $logger)
     {
         $this->token = $token;
         $this->client = new Client(['base_uri' => $baseUri]);
         $this->logger = $logger;
     }

     /**
      * @param Currency $currency
      * @return Currency Returns latest exchange rate
      * @throws Exception
      */
    public function getLatest(Currency $currency): Currency {

        $symbol = $currency->getSymbol();

        $uri = sprintf('/v1/latest?access_key=%s&symbols=%s', $this->token, $symbol);

        return $this->get($uri, $currency, $symbol);
    }

     /**
      * @param Currency $currency
      * @param Carbon $date
      * @return Currency Returns the exchange rate for the selected date
      * @throws Exception
      */
     public function getByDate(Currency $currency, Carbon $date): Currency {

         $symbol = $currency->getSymbol();

         $uri = sprintf('/v1/%s?access_key=%s&symbols=%s', $date->toDateString(), $this->token, $symbol);

         return $this->get($uri, $currency, $symbol);
     }

     /**
      * @param string $uri
      * @param Currency $currency
      * @param string $symbol
      * @return Currency
      * @throws Exception
      */
     private function get(string $uri, Currency $currency, string $symbol): Currency {
         try {
             $response = $this->client->get($uri);

             $result = json_decode($response->getBody()->getContents(), true);

             if (isset($result['rates'][$symbol])) {

                 $date = Carbon::createFromFormat('Y-m-d', $result['date']);

                 $currency->setPrice($result['rates'][$symbol]);
                 $currency->setDate($date);

                 return $currency;

             }
         } catch (\Throwable $e) {
             $this->logger->error($e);
         }

         throw new Exception('Unable to get rate!');
     }

}
