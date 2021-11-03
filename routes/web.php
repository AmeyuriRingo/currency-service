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

$router->get('/', 'PageController@index');

$router->get('/currencies/latest-rates', 'PageController@latestList');
$router->get('/currencies/latest-rates-with-symbols', 'PageController@listWithSymbols');
$router->get('/currencies/recommendations', 'PageController@recommendations');
