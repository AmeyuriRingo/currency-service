<?php

use App\Extensions\Currency\Currency;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class CurrencyTest extends TestCase
{
    /**
     * Test get currencies list method.
     */
    public function testGetList()
    {
        $list = Currency::getList();
        $this->assertEquals(true, $list->success);
    }

    /**
     * Test get currencies list according to symbols method.
     */
    public function testGetListWithSymbols()
    {
        $list = Currency::getList('BRL, USD');
        $this->assertEquals(true, $list->success);
    }

    /**
     * Test get recommendations for currencies list method.
     */
    public function testGetRecommendations()
    {
        $recommendations = Currency::getRecommendations('2021-10-17', '2021-10-18');
        $this->assertEquals(true, $recommendations['start']->success);
        $this->assertEquals(true, $recommendations['end']->success);
    }

    /**
     * Test get recommendations for currencies list according to symbols method.
     */
    public function testGetRecommendationsWithSymbols()
    {
        $recommendations = Currency::getRecommendations('2021-10-17', '2021-10-18', 'BRL, USD');
        $this->assertEquals(true, $recommendations['start']->success);
        $this->assertEquals(true, $recommendations['end']->success);
    }

    /**
     * Test guzzle functionality.
     *
     * @throws GuzzleException
     */
    public function testClient()
    {
        $mock = new MockHandler([
            new Response(200, [], 'Hello, World'),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $response = $client->request('GET', '/');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Hello, World', $response->getBody());
    }
}
