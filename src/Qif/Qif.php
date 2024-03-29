<?php

require_once __DIR__ . "/Parser/QifParser.php";
require_once __DIR__ . "/Generator/QifGeneratorHTML.php";

class Qif
{
    private QifParser $parser;
    private QifGeneratorHtml $generator;

    function __construct(
        public readonly string $content,
    ){
        $this->parser = new QifParser($content);
        $this->generator = new QifGeneratorHTML(
            $this->parser->getTransactions()
        );
    }

    function getHtml(): string {
        return $this->generator->generate();
    }
}
