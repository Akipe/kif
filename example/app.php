<?php

require __DIR__ . '/../vendor/autoload.php';

use Akipe\Kif\Kif;

$qifContent = file_get_contents(__DIR__ . "/input_test.qif");

$qif = new Kif($qifContent);

file_put_contents(__DIR__ . "/output_test.html", $qif->getHtml());
