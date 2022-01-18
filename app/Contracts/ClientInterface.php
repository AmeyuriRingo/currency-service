<?php

namespace App\Contracts;

interface ClientInterface
{

    public function getLatest($base, $symbol): float;

    public function getByDate($base, $symbol, $date): float;

    public function getRatesByDate($base, $symbol, $date): array;

}
