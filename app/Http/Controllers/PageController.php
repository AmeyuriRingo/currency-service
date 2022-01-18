<?php

namespace App\Http\Controllers;

use App\Contracts\Currency;
use App\Enums\CurrenciesEnum;
use App\Enums\StrategiesEnum;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laravel\Lumen\Application;

class PageController extends Controller
{
    private Currency $currency;

    public function __construct(Currency $currency)
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
        $currencies_list = CurrenciesEnum::toArray();
        if (empty($currencies_list[trim($request->symbol)])) {
            return view('home', ['error' => 'Incorrect currency: ' . $request->symbol]);
        }

        try {
            $rate = $this->currency->getLatestRate($request->base, $request->symbol);

            return view('rate', ['data' => [
                'base'=> 'EUR',
                'symbol' => $request->symbol,
                'rate'=> $rate
            ]]);
        } catch (\Exception $e) {

            return view('errors.404', ['errorMessage' => $e->getMessage()]);
        }

    }

    /**
     * Return page with list of rates recommendations according to start and end dates.
     *
     * @param Request $request
     * @return View|Application
     */
    public function rateByDate(Request $request)
    {
        $currencies_list = CurrenciesEnum::toArray();
        if (empty($currencies_list[trim($request->symbol)])) {
            return view('home', ['error' => 'Incorrect currency: ' . $request->symbol]);
        }

        try {
            $rate = $this->currency->getRateByDate($request->base, $request->symbol, $request->date);

            return view('rate', ['data' => [
                'base'=> 'EUR',
                'symbol' => $request->symbol,
                'date' => $request->date,
                'rate'=> $rate
            ]]);
        } catch (\Exception $e) {

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
        $currencies_list = CurrenciesEnum::toArray();
        if (empty($currencies_list[trim($request->symbol)])) {
            return view('home', ['error' => 'Incorrect currency: ' . $request->symbol]);
        }

        try {
            $recommendation = $this->currency->getRecommendation($request->base, $request->symbol, $request->strategy, $request->date);

            return view('recommendations', ['data' => [
                'base'=> 'EUR',
                'symbol' => $request->symbol,
                'date' => $request->date,
                'recommendation'=> $recommendation
            ]]);
        } catch (\Exception $e) {

            return view('errors.404', ['errorMessage' => $e->getMessage()]);
        }
    }
}
