<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/',[
    'as' => 'home',
    'uses' => 'PageController@index']
);

$router->get('/currencies/rate', 'PageController@rate');
$router->get('/currencies/rate-by-date', 'PageController@rateByDate');
$router->get('/currencies/recommendations', 'PageController@recommendations');
