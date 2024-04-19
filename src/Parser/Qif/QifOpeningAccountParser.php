<?php


namespace Akipe\Kif\Parser\Qif;

use Akipe\Kif\Parser\Qif\Element\QifOpeningElement;

class QifOpeningAccountParser extends QifElementCommonParser
{
  public function parse(): QifOpeningElement {
    return new QifOpeningElement(
      $this->parseDateAttribute(),
      $this->parseAmountAttribute(),
    );
  }
}

