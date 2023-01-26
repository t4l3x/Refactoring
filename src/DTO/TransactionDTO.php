<?php
namespace Talebyte\DTO;

class TransactionDTO
{
    /**
     * @var string
     */
    private string $bin;

    /**
     * @var float
     */
    private float $amount;

    /**
     * @var string
     */
    private string $currency;

    /**
     * @return string
     */
    public function getBin(): string
    {
        return $this->bin;
    }

    /**
     * @param string $bin
     */
    public function setBin(string $bin): void
    {
        $this->bin = $bin;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }


}