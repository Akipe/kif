<?php

namespace Akipe\Kif\Parser;

use Akipe\Kif\Element\QifAccount;
use Akipe\Kif\Parser\QifElementParser;
use Akipe\Kif\Element\QifElementAccount;
use Akipe\Kif\Element\QifElementTransaction;

class QifParser
{
  public const INFO_OPENING_TRANSACTION_ELEMENT_RULE = "!Type:Bank";
  public const FIRST_ELEMENT_ACCOUNT_RULE = "!Account";
  public const RULE_ACCOUNT_NAME = '';
  public const RULE_ACCOUNT_BASE = '';

  /** @var string[] */
  private readonly array $elements;

  public function __construct(
    private string $content,
  ) {
    $this->setElements();
  }

  /**
   * Get all transactions
   *
   * @return QifElementTransaction[]
   */
  public function getTransactions(): array {
    $transactions = [];

    // Parcourir toutes les transactions
    for (
      $index = $this->getFirstElementTransactionIndex();
      $index < count($this->elements);
      $index++
    ) {
      $transactions[] =
        (new QifElementParser($this->elements[$index]))
        ->getTransactionElement();
    }

    $this->sortTransactionsOldestToLatest($transactions);

    return $transactions;
  }

  /**
   *
   * @param QifElementTransaction[] $transactions
   * @return void
   */
  private function sortTransactionsOldestToLatest(array &$transactions): void {
    uasort(
      $transactions,
      function($previousTransaction, $nextTransaction) {
        return $previousTransaction->date <=> $nextTransaction->date;
      }
    );

    $transactions = array_values($transactions);
  }

  private function getOpeningAccountElementIndex(): int {
    foreach($this->elements as $index => $element) {
      if (str_contains($element, self::INFO_OPENING_TRANSACTION_ELEMENT_RULE)) {
        return $index;
      }
    }

    return 0;
  }

  private function getOpeningAccountElement(): QifElementTransaction {
    return (
      new QifElementParser(
        $this->elements[$this->getOpeningAccountElementIndex()]
      )
    )->getTransactionElement();
  }

  private function getAccountElement(): QifElementAccount {
    return (
      new QifElementParser(
        $this->elements[$this->getFirstElementAccountIndex()]
      )
    )->getAccountElement();
  }

  /**
   * Get first transaction index needed for fetching all next transactions elements
   *
   * @return int First element transaction index
   */
  private function getFirstElementTransactionIndex(): int {
    return ($this->getOpeningAccountElementIndex() + 1);
  }

  public function getAccount(): QifAccount {
    return new QifAccount(
      $this->getAccountElement()->name,
      $this->getOpeningAccountElement()->amount,
      $this->getTransactions(),
    );
  }

  /**
   * Parsing elements with element separator
   *
   * @return void
   */
  private function setElements(): void {
    $this->elements = array_filter(
      explode(QifElementParser::ELEMENT_SEPARATOR, trim($this->content)),
      fn($line) => !is_null($line) && trim($line) !== ""
    );
  }

  private function getFirstElementAccountIndex(): int {
    foreach($this->elements as $index => $element) {
      if (str_contains($element, self::FIRST_ELEMENT_ACCOUNT_RULE)) {
        return $index;
      }
    }

    return 0;
  }
}
