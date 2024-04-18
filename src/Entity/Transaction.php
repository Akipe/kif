<?php

namespace Akipe\Kif\Entity;

use DateTimeInterface;

class Transaction
{
  private ?float $balance;

  public function __construct(
    public readonly DateTimeInterface $date,
    public readonly string $note,
    public readonly float $amount,
    public readonly string $recipient,
    public readonly string $category,
  ){
    $this->balance = null;
  }

  public function setBalance(
    Transaction|float $previousTransaction
  ): void {
    if ($previousTransaction instanceof self) {
      if (!is_null($previousTransaction->balance)) {
        $this->balance = $this->amount + $previousTransaction->balance;
      }
    } else {
      $this->balance = $this->amount + $previousTransaction;
    }
  }

  public function getBalance(): float
  {
    return $this->balance;
  }
}
