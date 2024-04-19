<?php

namespace Akipe\Kif\Parser\Qif\ElementParser;

use Akipe\Kif\Entity\Transaction;

class QifTransactionParser extends QifElementCommonParser
{
  /**
   * Get parsed element with all his attributes
   *
   * @return Transaction
   */
  public function parse(): Transaction {
    return new Transaction(
      $this->parseDateAttribute(),
      $this->parseNoteAttribute(),
      $this->parseAmountAttribute(),
      $this->parseRecipientAttribute(),
      $this->parseCategoryAttribute(),
    );
  }
}
