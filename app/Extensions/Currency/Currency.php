<?php

namespace App\Extensions\Currency;

use App\Enums\CurrenciesEnum;
use Webmozart\Assert\Assert;

class Currency
{
    private string $currency;

    public function __construct(string $currency)
    {
        Assert::inArray($currency, CurrenciesEnum::toArray(), sprintf('Incorrect currency: %s', $currency));

        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }
}
