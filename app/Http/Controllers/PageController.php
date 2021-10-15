<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CurrencyController;
use App\Extensions\Currency\Currency;
use Illuminate\Http\Request;

class PageController extends Controller
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

    public function index()
    {
        return view('home');
    }

    public function list(Request $request) {
        $list = Currency::getList($request->base, $request->symbols);
        return view('list', ['data' => $list]);
    }

    public function recommendations(Request $request) {
        $recommendations = Currency::getRecommendations($request->start_date, $request->end_date, $request->symbols);
        return view('recommendations', ['data' => $recommendations]);
    }
}
