<?php
namespace Talebyte\Helpers;

class CommissionRates
{
    public static array $euRates = [
        'EUR' => 0.01,
        'USD' => 0.02,
        'GBP' => 0.03,
    ];

    public static array $nonEuRates = [
        'EUR' => 0.02,
        'USD' => 0.03,
        'GBP' => 0.04,
    ];

    public static function getRate(bool $isEu, string $currency): float
    {
        if($isEu)
            return self::$euRates[$currency] ?? 0;
        else
            return self::$nonEuRates[$currency] ?? 0;
    }
}