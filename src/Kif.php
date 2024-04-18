<?php

namespace Akipe\Kif;

use Akipe\Kif\Parser\Parser;
use Akipe\Kif\Entity\Account;
use Akipe\Kif\Generator\Generator;

class Kif
{
  private Account $account;

  public function parse(Parser $parser): self {
    $this->account = $parser->getAccount();

    return $this;
  }

  public function generateView(Generator $generator): string {
    return $generator
      ->load($this->account)
      ->generate();
  }
}
