<?php
namespace App\Extensions\Rate;

use App\Extensions\Currency\Currency;
use DateTimeImmutable;
use Exception;

class Rate
{

    protected Currency $base;
    protected Currency $symbol;
    protected float $price;
    protected DateTimeImmutable $date;

    public function __construct(Currency $base, Currency $symbol, float $price, DateTimeImmutable $date)
    {
        $this->base = $base;
        $this->symbol = $symbol;
        $this->price = $price;
        $this->date = $date;

    }

    /**
     *
     * Get base attribute
     *
     * @return Currency
     * @throws Exception
     */
    public function getBase(): Currency
    {
        if (isset($this->base)) {
            return $this->base;
        } else {
            throw new Exception('Unable to get currency');
        }

    }

    /**
     *
     * Get symbol attribute
     *
     * @return Currency
     * @throws Exception
     */
    public function getSymbol(): Currency
    {
        if (isset($this->symbol)) {
            return $this->symbol;
        } else {
            throw new Exception('Unable to get currency');
        }

    }

    /**
     *
     * Get price attribute
     *
     * @return float
     * @throws Exception
     */
    public function getPrice(): float
    {
        if (isset($this->price)) {
            return $this->price;
        } else {
            throw new Exception('Unable to get currency');
        }

    }

    /**
     *
     * Get date attribute
     *
     * @return DateTimeImmutable
     * @throws Exception
     */
    public function getDate(): DateTimeImmutable
    {
        if (isset($this->date)) {
            return $this->date;
        } else {
            throw new Exception('Unable to get currency');
        }

    }
}