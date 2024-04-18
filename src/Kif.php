<?php

namespace Akipe\Kif;

use Akipe\Kif\Parser\QifParser;
use Akipe\Kif\Generator\QifGeneratorHTML;

class Kif
{
  private QifParser $parser;
  private QifGeneratorHtml $generator;

  public function __construct(
    public readonly string $content,
  ){
    $this->parser = new QifParser($content);

    $this->generator = new QifGeneratorHTML(
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
