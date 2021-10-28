<?php

namespace App\Http\Controllers;

use App\Extensions\Currency\Currency;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laravel\Lumen\Application;

class PageController extends Controller
{
    /**
     * @return View|Application
     */
    public function index()
    {
        return view('home');
    }

    /**
     * @param Request $request
     * @return View|Application
     */
    public function list(Request $request) {
        $list = Currency::getList($request->symbols);
        if (isset($list->error)) return view('home', ['list_error' => $list->error]);
        return view('list', ['data' => $list]);
    }

    /**
     * @param Request $request
     * @return View|Application
     */
    public function recommendations(Request $request) {
        $recommendations = Currency::getRecommendations($request->start_date, $request->end_date, $request->symbols);
        if (isset($recommendations->error)) return view('home', ['recommendations_error' => $recommendations->error]);
        return view('recommendations', ['data' => $recommendations]);
    }
}
