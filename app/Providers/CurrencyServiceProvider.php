<?php

namespace App\Providers;

use App\Contracts\ClientInterface;
use App\Extensions\ExchangeRates\DummyExchangeRate;
use Illuminate\Support\ServiceProvider;
use App\Contracts\CurrencyService;
use App\Extensions\ExchangeRates\ExchangeRates;
use App\Extensions\RateClient\RateClient;
use Psr\Log\LoggerInterface;

class CurrencyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ClientInterface::class, function ($app) {
            return new RateClient(env('CURRENCY_TOKEN'), 'http://api.exchangeratesapi.io', $app->make(LoggerInterface::class));
        });


        $this->app->bind(CurrencyService::class, function () {
            if (env('APP_ENV') === 'prod') {
                return new ExchangeRates($this->app->make(ClientInterface::class));
            }

            return new DummyExchangeRate();
        });
    }
}
