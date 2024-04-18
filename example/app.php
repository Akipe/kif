<?php

require __DIR__ . '/../vendor/autoload.php';

use Akipe\Kif\Kif;

$kif = new Kif();

$htmlContent = $kif
  ->parseQif(file_get_contents(__DIR__ . "/input_test.qif"))
  ->generateHtml();

file_put_contents(__DIR__ . "/output_test.html", $htmlContent);
