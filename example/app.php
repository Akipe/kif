<?php

require_once __DIR__ . "/../src/Qif/Qif.php";

$qifContent = file_get_contents("./input_test.qif");

$qif = new Qif($qifContent);

file_put_contents("./output_test.html", $qif->getHtml());
