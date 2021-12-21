<?php

namespace App\Contracts;

interface Currency
{
    public function getRate($base, $symbol, $date = ''): float;

    public function getRecommendation($base, $symbol, $date): float;

}
