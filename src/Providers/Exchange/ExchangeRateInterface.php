<?php

namespace Talebyte\Providers\Exchange;

interface ExchangeRateInterface
{
    public function getExchangeRate(string $currency): float;
}
