<?php

namespace Classes;

use Classes\Factory\ExchangeRateConnector;
use ErrorException;

class ApilayerExchangeRateConnector implements ExchangeRateConnector
{
    
    public function getLatestRate(String $currency): float
    {
        $url = 'https://api.apilayer.com/exchangerates_data/latest?apikey='.$_ENV['APILAYER_KEY'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3000);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10000);
        $result = curl_exec($ch);
        curl_close($ch);
        $rate = json_decode($result, true)['rates'][$currency];
        if (!isset($rate)) {
            throw new ErrorException('Error while getting rate');
        }

        return $rate;
    }
}