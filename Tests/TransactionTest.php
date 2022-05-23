<?php

use Classes\ApilayerExchangeRateConnector;
use Classes\LookupBinlistConnector;
use Classes\Transaction;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{

    public static function providerTransaction ()
    {
        return [
            [
                '{"bin":"45717360","amount":"100.00","currency":"EUR"}',
                1
            ],

        ];
    }

    /**
    * @dataProvider providerTransaction
    */
    public function testCalculate($data, $result)
    {
        $transaction = new Transaction();

        $parsedTransaction = $transaction->getParseTransactionData($data);
        $this->assertEquals($result, $transaction->calculate($parsedTransaction));
    }

    /**
    * @dataProvider providerTransaction
    */
    public function testCalculateCommision($data, $result)
    {
        $isEucountry = true;
        $latestRate = 1.0;
        $binListMock = $this->createMock(LookupBinlistConnector::class);
        $binListMock
            ->method('checkIsEuCountry')
            ->willReturn($isEucountry);

        $exchangeRateMock = $this->createMock(ApilayerExchangeRateConnector::class);

        $exchangeRateMock
            ->method('getLatestRate')
            ->willReturn($latestRate);
        
        $transaction = json_decode($data);

        if ($transaction->currency === 'EUR' || $latestRate === 0) {
            $amountFixed = $transaction->amount;
        }
        if ($transaction->currency !== 'EUR' || $latestRate > 0) {
            $amountFixed = $transaction->amount / $latestRate;
        }
        $this->assertEquals($result, round($amountFixed * ($isEucountry ? 0.01 : 0.02), 2));
    }
}