<?php

namespace Akipe\Kif\Parser\Grisbi\Node;

use Akipe\Kif\Parser\Grisbi\Node\GrisbiParty;
use Akipe\Kif\Parser\Grisbi\Node\GrisbiAccount;
use Akipe\Kif\Parser\Grisbi\Node\GrisbiPaymentType;
use Akipe\Kif\Parser\Grisbi\Node\GrisbiTransaction;

class GrisbiRoot
{
    /**
     * @param GrisbiAccount[] $accounts
     * @param GrisbiPaymentType[] $payments
     * @param GrisbiTransaction[] $transactions
     * @param GrisbiParty[] $parties
     * @return void
     */
    public function __construct(
        public readonly array $accounts,
        public readonly array $payments,
        public readonly array $transactions,
        public readonly array $parties,
    ) {
    }

    // public function addAccount();
}
