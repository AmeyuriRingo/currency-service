<?php

namespace App\Extensions\RateClient;

use App\Extensions\Currency\Currency;
use App\Extensions\Rate\Rate;
use DateTimeImmutable;
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
      * @param Currency $base
      * @param Currency $symbol
      * @return Rate Returns latest exchange rate
      * @throws Exception
      */
    public function getLatest(Currency $base, Currency $symbol): Rate {

        $uri = sprintf('/v1/latest?access_key=%s&symbols=%s', $this->token, $symbol->getCurrency());

        return $this->get($uri, $base, $symbol);
    }

     /**
      * @param Currency $base
      * @param Currency $symbol
      * @param DateTimeImmutable $date
      * @return Rate Returns the exchange rate for the selected date
      * @throws Exception
      */
     public function getByDate(Currency $base, Currency $symbol, DateTimeImmutable $date): Rate {

         $uri = sprintf('/v1/%s?access_key=%s&symbols=%s', $date->format('Y-m-d'), $this->token, $symbol->getCurrency());

         return $this->get($uri, $base, $symbol);
     }

     /**
      * @param string $uri
      * @param Currency $base
      * @param Currency $symbol
      * @return Rate
      * @throws Exception
      */
     private function get(string $uri, Currency $base, Currency $symbol): Rate {
         try {
             $response = $this->client->get($uri);

             $result = json_decode($response->getBody()->getContents(), true);

             if (isset($result['rates'][$symbol->getCurrency()])) {

                 $date = new DateTimeImmutable($result['date']);

                 return new Rate($base, $symbol, $result['rates'][$symbol->getCurrency()], $date);

             } else {
                 $this->logger->error($result['error']);
             }
         } catch (\Throwable $e) {
             $this->logger->error($e);
         }

         throw new Exception('Unable to get rate');
     }

}
