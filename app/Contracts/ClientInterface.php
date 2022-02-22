<?php

namespace App\Contracts;

use App\Extensions\Currency\Currency;
use Carbon\Carbon;

interface ClientInterface
{

    public function getLatest(Currency $currency): Currency;

    public function getByDate(Currency $currency, Carbon $date): Currency;

}
