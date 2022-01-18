<?php

namespace App\Contracts;

interface Currency
{
    public function getLatestRate($base, $symbol): float;

    public function getRateByDate($base, $symbol, $date): float;

    public function getRecommendation($base, $symbol, $strategy, $date = ''): float;

}
