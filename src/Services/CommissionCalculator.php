<?php

namespace Talebyte\Services;

use Exception;
use Talebyte\DTO\TransactionDTO;
use Talebyte\Helpers\CommissionRates;
use Talebyte\Providers\BinLookup\BinLookupInterface;
use Talebyte\Providers\Exchange\ExchangeRateInterface;


class CommissionCalculator
{
    private BinLookupInterface $binLookup;

    private ExchangeRateInterface $exchangeRate;


    private array $euCountries = ['AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LT', 'LU', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK'];

    public function __construct(BinLookupInterface $binLookup, ExchangeRateInterface $exchangeRate)
    {
        $this->binLookup = $binLookup;
        $this->exchangeRate = $exchangeRate;
    }

    /**
     * @throws Exception
     */
    public function calculateCommission(TransactionDTO $transactionDTO): float
    {
        try {
            $binResults = $this->binLookup->getCountry($transactionDTO->getBin());
            $isEu = in_array($binResults['country']['alpha2'], $this->euCountries);
            $rate = $this->exchangeRate->getExchangeRate($transactionDTO->getCurrency());
            $amntFixed = $transactionDTO->getAmount();
            if ($transactionDTO->getCurrency() != 'EUR' and $rate > 0) {
                $amntFixed = $transactionDTO->getAmount() / $rate;
            }
            return round($amntFixed * CommissionRates::getRate($isEu,$transactionDTO->getCurrency()), 2);
        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }
    }

    private function isEu(string $c): bool
    {
        return in_array($c, $this->euCountries);
    }
}
