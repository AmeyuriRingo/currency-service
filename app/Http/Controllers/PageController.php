<?php

namespace App\Http\Controllers;

use App\Contracts\Currency;
use App\Enums\CurrenciesEnum;
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
        return view('home');
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

        $rate = $this->currency->getRate($request->base, $request->symbol);

        if ($rate !== 0.0) {
            return view('rate', ['data' => [
                'base'=> 'EUR',
                'symbol' => $request->symbol,
                'rate'=> $rate
            ]]);
        } else {
            return view('errors.404');
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

        $recommendation = $this->currency->getRecommendation($request->base, $request->symbol, $request->date);

        return view('recommendations', ['data' => [
            'base'=> 'EUR',
            'symbol' => $request->symbol,
            'date' => $request->date,
            'recommendation'=> $recommendation
        ]]);
    }
}
