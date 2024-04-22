<?php

require __DIR__ . '/../vendor/autoload.php';

use Akipe\Kif\Kif;
use Akipe\Kif\Parser\Grisbi\GrisbiParser;
use Akipe\Kif\Parser\Qif\QifParser;
use Akipe\Kif\ViewGenerator\Html\HtmlGenerator;

const QIF_FILE_PATH = __DIR__ . "/input_test.qif";

$qifContent = file_get_contents(QIF_FILE_PATH);

if (empty($qifContent)) {
    throw new Exception("Can't load data for file " . QIF_FILE_PATH);
}

$kif = new Kif();

$htmlContent = $kif
  ->parse(new QifParser($qifContent))
  ->generateView(new HtmlGenerator());

file_put_contents(__DIR__ . "/output_test.html", $htmlContent);
