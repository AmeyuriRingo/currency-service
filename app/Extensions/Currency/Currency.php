<?php
namespace App\Extensions\Currency;

use Exception;
use Carbon\Carbon;

class Currency
{

    protected string $base;
    protected string $symbol;
    protected float $price;
    protected Carbon $date;

    public function __construct(string $base, string $symbol)
    {
        $this->base = $base;
        $this->symbol = $symbol;
    }

    /**
     *
     * Get base attribute
     *
     * @return string
     * @throws Exception
     */
    public function getBase(): string
    {
        if (isset($this->base)) {
            return $this->base;
        } else {
            throw new Exception('Unable to get currency!');
        }

    }

    /**
     *
     * Get symbol attribute
     *
     * @return string
     * @throws Exception
     */
    public function getSymbol(): string
    {
        if (isset($this->symbol)) {
            return $this->symbol;
        } else {
            throw new Exception('Unable to get currency!');
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
            throw new Exception('Unable to get currency!');
        }

    }

    /**
     *
     * Get date attribute
     *
     * @return Carbon
     * @throws Exception
     */
    public function getDate(): Carbon
    {
        if (isset($this->date)) {
            return $this->date;
        } else {
            throw new Exception('Unable to get currency!');
        }

    }

    /**
     *
     * Set price attribute
     *
     * @param float $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     *
     * Set date attribute
     *
     * @param Carbon $date
     */
    public function setDate(Carbon $date)
    {
        $this->date = $date;
    }
}