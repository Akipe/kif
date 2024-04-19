<?php

namespace Akipe\Kif\Parser\Qif\ElementParser;

use Akipe\Kif\Parser\Qif\Element\QifAccountInformation;

class QifAccountInformationParser extends QifElementCommonParser
{
  public function parse(): QifAccountInformation {
    return new QifAccountInformation(
      $this->parseAccountNameAttribute(),
    );
  }
}

