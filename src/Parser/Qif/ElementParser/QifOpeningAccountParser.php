<?php


namespace Akipe\Kif\Parser\Qif\ElementParser;

use Akipe\Kif\Parser\Qif\Element\QifOpening;

class QifOpeningAccountParser extends QifElementCommonParser
{
  public function parse(): QifOpening {
    return new QifOpening(
      $this->parseDateAttribute(),
      $this->parseAmountAttribute(),
    );
  }
}

