<?php

declare(strict_types=1);

use Akipe\Kif\Kif;
use PHPUnit\Framework\TestCase;
use Akipe\Kif\Parser\Qif\QifParser;
use Akipe\Kif\ViewGenerator\Html\HtmlGenerator;

final class KifTest extends TestCase
{
    public function test_qif_to_html_is_result_expected(): void
    {
        $qif = file_get_contents(__DIR__ . "/KifTestInput.qif");
        $htmlExpected = file_get_contents(__DIR__ . "/KifTestOutput.html");

        $kif = new Kif();

        $qifParser = new QifParser($qif);
        $htmlGenerator = new HtmlGenerator();

        $htmlGenerated = $kif
          ->parse($qifParser)
          ->generateView($htmlGenerator);

        $this->assertEquals($htmlExpected, $htmlGenerated);
    }
}
