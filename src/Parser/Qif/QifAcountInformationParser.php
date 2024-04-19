<?php


namespace Akipe\Kif\Parser\Qif;

use Akipe\Kif\Parser\Qif\Element\QifAccountInformationElement;

class QifAccountInformationParser extends QifElementCommonParser
{
  public function parse(): QifAccountInformationElement {
    return new QifAccountInformationElement(
      $this->parseAccountNameAttribute(),
    );
  }
}

