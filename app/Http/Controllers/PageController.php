<?php

namespace App\Http\Controllers;

use App\Enums\StrategiesEnum;
use App\Contracts\CurrencyService;
use App\Extensions\Currency\Currency;
use App\Extensions\ExchangeRates\RecommendationStrategies\ByDateStrategy;
use App\Extensions\ExchangeRates\RecommendationStrategies\LatestStrategy;
use DateTimeImmutable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laravel\Lumen\Application;

class PageController extends Controller
{
    private CurrencyService $currency;

    public function __construct(CurrencyService $currency)
    {
        $this->currency = $currency;
    }

    /**
     * Return home page.
     *
     * @return View|Application
     */
    public function index()
    {
        return view('home', ['strategies' => StrategiesEnum::toArray()]);
    }

    /**
     * Return page with the exchange rate according to the base currency and symbol.
     *
     * @param Request $request
     * @return View|Application
     */
    public function rate(Request $request)
    {
        try {
            $symbol = new Currency($request->symbol);
            $base = new Currency($request->base);
        } catch (\InvalidArgumentException $e) {
            return view('home', ['error' => $e->getMessage(), 'strategies' => StrategiesEnum::toArray()]);
        }

        try {
            $rate = $this->currency->getLatestRate($base, $symbol);

            return view('rate', ['data' => [
                'base'=> 'EUR',
                'symbol' => $request->symbol,
                'rate'=> $rate->getPrice()
            ]]);
        } catch (Exception $e) {

            return view('errors.404', ['errorMessage' => $e->getMessage()]);
        }

    }

    /**
     * Return page with list of rates recommendations according to start and end dates.
     *
     * @param Request $request
     * @return View|Application
     * @throws Exception
     */
    public function rateByDate(Request $request)
    {
        try {
            $symbol = new Currency($request->symbol);
            $base = new Currency($request->base);
            $date = new DateTimeImmutable( $request->date);
        } catch (\InvalidArgumentException $e) {
            return view('home', ['error' => $e->getMessage()]);
        }


        try {
            $rate = $this->currency->getRateByDate($base, $symbol, $date);

            return view('rate', ['data' => [
                'base'=> 'EUR',
                'symbol' => $request->symbol,
                'date' => $request->date,
                'rate'=> $rate->getPrice()
            ]]);
        } catch (Exception $e) {

            return view('errors.404', ['errorMessage' => $e->getMessage()]);
        }
    }


    /**
     * Return page with list of rates recommendations according to start and end dates.
     *
     * @param Request $request
     * @return View|Application
     */
    public function recommendations(Request $request)
    {
        try {
            $symbol = new Currency($request->symbol);
            $base = new Currency($request->base);
        } catch (\InvalidArgumentException $e) {
            return view('home', ['error' => $e->getMessage()]);
        }

        try {

            if ($request->strategy == StrategiesEnum::LATEST()) {
                $strategy = new LatestStrategy();
                $recommendation = $this->currency->getRecommendation($base, $symbol, $strategy);
            } else if ($request->strategy == StrategiesEnum::BY_DATE()) {
                $strategy = new ByDateStrategy();
                $date = new DateTimeImmutable($request->date);
                $recommendation = $this->currency->getRecommendation($base, $symbol, $strategy, $date);
            }

            return view('recommendations', ['data' => [
                'base'=> 'EUR',
                'symbol' => $request->symbol,
                'date' => $request->date,
                'recommendation'=> $recommendation
            ]]);
        } catch (Exception $e) {

            return view('errors.404', ['errorMessage' => $e->getMessage()]);
        }
    }
}
