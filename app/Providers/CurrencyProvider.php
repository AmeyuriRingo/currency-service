<?php

namespace App\Providers;

use App\Contracts\ClientInterface;
use Illuminate\Support\ServiceProvider;
use App\Extensions\Currency\CurrencyService;
use App\Contracts\Currency;
use App\Extensions\ExchangeRates\ExchangeRates;
use App\Extensions\RateClient\RateClient;
use App\Extensions\DummyExchangeRates\DummyExchangeRate;

class CurrencyProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ClientInterface::class, function () {
            return new RateClient(env('CURRENCY_TOKEN'));
        });

        $this->app->bind(Currency::class, function () {
            return new CurrencyService(new ExchangeRates($this->app->make(ClientInterface::class)));
        });
    }
}
