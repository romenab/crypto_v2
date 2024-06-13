<?php

namespace CryptoTrade\App;

class Currency
{
    private string $name;
    private string $symbol;
    private float $price;
    private float $oneHour;
    private float $twentyFourHour;
    private float $sevenDays;
    private float $marketCap;
    public function __construct(
        string $name,
        string $symbol,
        float $price,
        float $oneHour,
        float $twentyFourHour,
        float $sevenDays,
        float $marketCap
    )
    {
        $this->name = $name;
        $this->symbol = $symbol;
        $this->price = $price;
        $this->oneHour = $oneHour;
        $this->twentyFourHour = $twentyFourHour;
        $this->sevenDays = $sevenDays;
        $this->marketCap = $marketCap;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getSymbol(): string
    {
        return $this->symbol;
    }
    public function getPrice(): float
    {
        return $this->price;
    }
    public function getOneHour(): float
    {
        return $this->oneHour;
    }
    public function getTwentyFourHour(): float
    {
        return $this->twentyFourHour;
    }
    public function getSevenDays(): float
    {
        return $this->sevenDays;
    }
    public function getMarketCap(): float
    {
        return $this->marketCap;
    }
}
