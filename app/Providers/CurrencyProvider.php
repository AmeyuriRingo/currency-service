<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Extensions\Currency\CurrencyService;
use App\Contracts\Currency;
use App\Extensions\ExchangeRates\ExchangeRates;

class CurrencyProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Currency::class, function ($app) {
            return new CurrencyService(new ExchangeRates(env('CURRENCY_TOKEN')));
        });
    }
}
