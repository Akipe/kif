<?php

include_once "../src/QifGeneratorHTML.php";
include_once "../src/QifParser.php";

$qifContent = file_get_contents("./input_test.qif");

$parser = new QifParser($qifContent);
$listTransactions = $parser->getTransactions();
$generator = new QifGeneratorHTML($listTransactions);
$output = $generator->generate();

file_put_contents("./output_test.html", $output);
