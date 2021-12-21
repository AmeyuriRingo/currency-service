<?php

namespace App\Contracts;

interface ClientInterface
{
    public function fetch($baseUri, $method, $uri);

    public function getLatest($base, $symbol): float;

    public function getRecommendation($base, $symbol, $date): float;
}
