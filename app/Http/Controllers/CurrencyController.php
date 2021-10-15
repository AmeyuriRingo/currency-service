<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\View\View;
use Laravel\Lumen\Application;


class CurrencyController extends Controller
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
     * Returns the list of latest exchange rates
     *
     * @return View|Application
     * @throws GuzzleException
     */
    public static function getList() {
        $client = new Client(['base_uri' => 'http://api.exchangeratesapi.io']);
        $response = $client->request('POST', '/v1/latest?access_key=6a4e4f160a7e9f3f2e6beb191e4a5968');
        $resultJson = json_decode($response->getBody()->getContents());
        return $resultJson;
    }

    /**
     * Return recommendations according to date
     *
     * @return View|Application
     * @throws GuzzleException
     */
    public static function getRecommendations($startDate = 0, $endDate = 0) {
        $client = new Client(['base_uri' => 'http://api.exchangeratesapi.io']);
        $startResponse = $client->request('POST', '/v1/'. $startDate .'?access_key=6a4e4f160a7e9f3f2e6beb191e4a5968');
        $startResponse = $client->request('POST', '/v1/'. $startDate .'?access_key=6a4e4f160a7e9f3f2e6beb191e4a5968');
        $startResultJson = json_decode($startResponse->getBody()->getContents());
        $startResultJson = json_decode($startResponse->getBody()->getContents());
        return view('recommendations');
    }
}
