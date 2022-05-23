<?php

namespace Classes;

use Classes\Factory\BinListConnector;
use ErrorException;

class LookupBinlistConnector implements BinListConnector
{
    private static $euCountries = [
        'AT',
        'BE',
        'BG',
        'CY',
        'CZ',
        'DE',
        'DK',
        'EE',
        'ES',
        'FI',
        'FR',
        'GR',
        'HR',
        'HU',
        'IE',
        'IT',
        'LT',
        'LU',
        'LV',
        'MT',
        'NL',
        'PO',
        'PT',
        'RO',
        'SE',
        'SI',
        'SK',
    ];

    public function getBinResult(String $bin): object
    {
        $binResult = file_get_contents('https://lookup.binlist.net/' . $bin);
        if (!isset($binResult)) {
            throw new ErrorException('Error while getting bin result');
        }
        return json_decode($binResult);
    }

    public function checkIsEuCountry(String $bin): bool
    {
        $binResult = $this->getBinResult($bin);
        return in_array($binResult->country->alpha2, self::$euCountries);
    }
}