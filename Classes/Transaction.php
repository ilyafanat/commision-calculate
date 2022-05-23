<?php

namespace Classes;

use Classes\Factory\BinListConnector;
use Classes\Factory\ExchangeRateConnector;

use Classes\Factory\CalculateCommision;

class Transaction extends CalculateCommision
{
    
    public function getBinList(): BinListConnector
    {
        return new LookupBinlistConnector();
    }

    public function getExchangeRate(): ExchangeRateConnector
    {
        return new ApilayerExchangeRateConnector();
    }

    public function getParseTransactionData($transactionData)
    {
        return json_decode($transactionData);
    }
}