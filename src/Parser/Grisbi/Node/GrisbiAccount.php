<?php

namespace Akipe\Kif\Parser\Grisbi\Node;

class GrisbiAccount
{
    ///** @var GrisbiPaymentType[] */
    // private array $paymentTypes;
    ///** @var GrisbiTransaction[] */
    // private array $transactions;

    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly float $initialBalance,
        public readonly string $comment,
    ) {
        // $this->paymentTypes = [];
        // $this->transactions = [];
    }

    // public function addPayment(GrisbiPaymentType $paymentType)
    // {
    //     $this->paymentTypes[] = $paymentType;
    // }

    // public function addTransaction(GrisbiTransaction $transaction)
    // {
    //     $this->transactions[] = $transaction;
    // }
}
