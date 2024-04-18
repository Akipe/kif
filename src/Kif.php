<?php

namespace Akipe\Kif;

use Akipe\Kif\Parser\Parser;
use Akipe\Kif\Parser\Qif\QifParser;
use Akipe\Kif\Generator\HtmlGenerator;

class Kif
{
  private Parser $parser;
  private HtmlGenerator $generator;

  public function __construct(
    public readonly string $content,
  ){
    $this->parser = new QifParser($content);

    $this->generator = new HtmlGenerator(
        $this->parser->getAccount()
    );
  }

  /**
   *
   * @param string $cssFilePath
   * @return array{html: string, css: string}
   */
  public function getHtml(string $cssFilePath): array {
    return $this->generator->generate($cssFilePath);
  }
}
