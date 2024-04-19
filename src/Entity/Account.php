<?php

namespace Akipe\Kif\Entity;

use Akipe\Kif\Entity\Transaction;
use DateTimeInterface;

class Account
{
  /**
   *
   * @param string $name
   * @param float $amountStart
   * @param Transaction[] $transactions
   * @return void
   */
  public function __construct(
    public readonly string $name,
    public readonly float $amountStart,
    public readonly array $transactions,
  )
  {
    $this->setBalanceTransactions();
  }

  public function setBalanceTransactions(): void
  {
    for ($index = 0; $index < count($this->transactions); $index++) {
      if ($index == 0) {
        $this->transactions[$index]->setBalance($this->getOpeningAmount());
      } else {
        $this->transactions[$index]->setBalance($this->transactions[$index - 1]);
      }
    }
  }

  public function getFirstTransactionDate(): DateTimeInterface
  {
    return $this->transactions[0]->date;
  }

  public function getLastTransactionDate(): DateTimeInterface
  {
    return $this->getLastTransaction()->date;
  }

  public function getOpeningAmount(): float
  {
    return $this->amountStart;
  }

  public function getClosingAmount(): float
  {
    return $this->getLastTransaction()->getBalance();
  }

  private function getLastTransaction(): Transaction
  {
    return $this->transactions[array_key_last($this->transactions)];
  }
}
