<?php

namespace Akipe\Kif\Parser\Qif\NodeParser;

use Akipe\Kif\Entity\Transaction;

class QifTransactionParser extends QifNodeParser
{
  /**
   * Get parsed node with all his attributes
   *
   * @return Transaction
   */
    public function parse(): Transaction
    {
        return new Transaction(
            $this->parseDateAttribute(),
            $this->parseNoteAttribute(),
            $this->parseAmountAttribute(),
            $this->parseRecipientAttribute(),
            $this->parseCategoryAttribute(),
        );
    }
}
