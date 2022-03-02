<?php

namespace App\Contracts;

use App\Extensions\Currency\Currency;
use App\Extensions\Rate\Rate;
use DateTimeImmutable;

interface ClientInterface
{

    public function getLatest(Currency $base, Currency $symbol): Rate;

    public function getByDate(Currency $base, Currency $symbol, DateTimeImmutable $date): Rate;

}
