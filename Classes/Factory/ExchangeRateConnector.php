<?php

namespace Classes\Factory;

interface ExchangeRateConnector
{
    public function getLatestRate(String $currency): float;
}