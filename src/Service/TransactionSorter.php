<?php

namespace Akipe\Kif\Service;

use Akipe\Kif\Entity\Transaction;

class TransactionSorter
{
    /**
     *
     * @param Transaction[] $transactions
     * @return void
     */
    public static function oldestToLatest(array &$transactions): void
    {
        uasort(
            $transactions,
            fn ($previousTransaction, $nextTransaction)
                => $previousTransaction->date <=> $nextTransaction->date
        );

        $transactions = array_values($transactions);
    }
}
