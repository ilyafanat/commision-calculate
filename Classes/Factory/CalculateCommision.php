<?php

namespace Classes\Factory;

use Classes\Factory\BinListConnector;
use Classes\Factory\ExchangeRateConnector;

abstract class CalculateCommision
{

    abstract public function getBinList(): BinListConnector;
    abstract public function getExchangeRate(): ExchangeRateConnector;

    public function calculate($transaction): float
    {

        $binList = $this->getBinList();
        $isEuCountry = $binList->checkIsEuCountry($transaction->bin);

        $exchangeRate = $this->getExchangeRate();
        $latestRate = $exchangeRate->getLatestRate($transaction->currency);


        if ($transaction->currency === 'EUR' || $latestRate === 0) {
            $amountFixed = $transaction->amount;
        }
        if ($transaction->currency !== 'EUR' || $latestRate > 0) {
            $amountFixed = $transaction->amount / $latestRate;
        }
    
        return round($amountFixed * ($isEuCountry ? 0.01 : 0.02), 2);
    }
}