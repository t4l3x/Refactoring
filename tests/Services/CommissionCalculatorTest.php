<?php
use PHPUnit\Framework\TestCase;

use Talebyte\DTO\TransactionDTO;
use Talebyte\Helpers\CommissionRates;
use Talebyte\Providers\BinLookup\BinLookupInterface;
use Talebyte\Providers\Exchange\ExchangeRateInterface;
use Talebyte\Services\CommissionCalculator;

class CommissionCalculatorTest extends TestCase
{
    private CommissionCalculator $calculator;

    private BinLookupInterface $binLookup;

    private ExchangeRateInterface $exchangeRate;

    private $commissionRate;

    public function setUp(): void
    {
        $this->binLookup = $this->createMock(BinLookupInterface::class);
        $this->exchangeRate = $this->createMock(ExchangeRateInterface::class);
        $this->commissionRate = $this->createMock(CommissionRates::class);
        $this->calculator = new CommissionCalculator($this->binLookup, $this->exchangeRate, $this->commissionRate);
    }

    /**
     * @throws Exception
     */
    public function testCalculateCommission()
    {
        // Prepare the mock objects
        $this->binLookup->method('getCountry')->willReturn(['country' => ['alpha2' => 'DE']]);
        $this->exchangeRate->method('getExchangeRate')->willReturn(1.1233);

        // Create a TransactionDTO instance
        $transactionDTO = new TransactionDTO();
        $transactionDTO->setAmount('100.00');
        $transactionDTO->setBin('45717360');
        $transactionDTO->setCurrency('EUR');


        // Call the calculateCommission method
        $commission = $this->calculator->calculateCommission($transactionDTO);

        // Assert that the calculated commission is as expected
        $this->assertEquals(1, $commission);
    }
}