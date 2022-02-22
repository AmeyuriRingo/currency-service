<?php

namespace App\Contracts;

use App\Enums\CurrenciesEnum;
use Webmozart\Assert\Assert;

class CheckCurrency
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
