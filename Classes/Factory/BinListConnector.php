<?php

namespace Classes\Factory;

interface BinListConnector
{
    public function getBinResult(String $bin): object;
    public function checkIsEuCountry(String $bin): bool;
}