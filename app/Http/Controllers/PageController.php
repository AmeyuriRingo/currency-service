<?php

namespace App\Http\Controllers;

use App\Contracts\Currency;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laravel\Lumen\Application;
use Illuminate\Support\Carbon;

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
     * Return page with list of the latest currencies.
     *
     * @return View|Application
     */
    public function latestList()
    {
        $list = $this->currency->getList();

        if (isset($list->error)) {
            return view('home', ['list_error' => $list->error]);
        }
        return view('list', ['data' => $list]);
    }

    /**
     * Return page with list of the latest currencies according to symbols.
     *
     * @param Request $request
     * @return View|Application
     */
    public function listWithSymbols(Request $request)
    {
        $list = $this->currency->getList($request->symbols);

        if (isset($list->error)) {
            return view('home', ['list_error' => $list->error]);
        }
        return view('list', ['data' => $list]);
    }

    /**
     * Return page with list of rates recommendations according to start and end dates.
     *
     * @param Request $request
     * @return View|Application
     */
    public function recommendations(Request $request)
    {
        $now = Carbon::now()->toDateString();

        if ($request->start_date > $request->end_date) {
            return view('home', ['recommendations_error' => 'The start date cannot be later than the end date']);
        }
        if ($request->start_date > $now || $request->end_date > $now) {
            return view('home', ['recommendations_error' => 'Invalid start or end date']);
        }

        $recommendations = $this->currency->getRecommendations($request->start_date, $request->end_date, $request->symbols);

        if (isset($recommendations->error)) {
            return view('home', ['recommendations_error' => $recommendations->error]);
        }
        return view('recommendations', ['data' => $recommendations]);
    }
}
