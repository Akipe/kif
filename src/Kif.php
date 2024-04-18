<?php

namespace Akipe\Kif;

use Akipe\Kif\Parser\Parser;
use Akipe\Kif\Entity\Account;
use Akipe\Kif\Generator\Generator;
use Akipe\Kif\Parser\Qif\QifParser;
use Akipe\Kif\Generator\Html\HtmlGenerator;

class Kif
{
  private Parser $parser;
  private Generator $generator;
  private Account $account;

  public function parseQif(string $content): self {
    $this->parser = new QifParser($content);
    $this->account = $this->parser->getAccount();

    return $this;
  }

  public function generateHtml(): string {
    $this->generator = new HtmlGenerator(
      $this->account,
    );

    return $this->generator->generate();
  }
}
