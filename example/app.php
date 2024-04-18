<?php

require __DIR__ . '/../vendor/autoload.php';

use Akipe\Kif\Kif;
use Akipe\Kif\Parser\Qif\QifParser;
use Akipe\Kif\ViewGenerator\Html\HtmlGenerator;

$kif = new Kif();

$htmlContent = $kif
  ->parse(new QifParser(file_get_contents(__DIR__ . "/input_test.qif")))
  ->generateView(new HtmlGenerator());

file_put_contents(__DIR__ . "/output_test.html", $htmlContent);
