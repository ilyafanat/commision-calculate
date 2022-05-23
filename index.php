<?php
require 'vendor/autoload.php';

use Classes\Transaction;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$transaction = new Transaction();

foreach (explode("\n", file_get_contents($argv[1])) as $row) {
    if (empty($row)) {
        throw new ErrorException('Empty row');
    }

    $parsedTransactionData = $transaction->getParseTransactionData($row);
    echo $transaction->calculate($parsedTransactionData);
    print "\n";
}