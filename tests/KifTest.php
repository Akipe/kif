<?php

declare(strict_types=1);

use Akipe\Kif\Kif;
use PHPUnit\Framework\TestCase;

final class KifTest extends TestCase
{
    public function test_qif_to_html_is_result_expected(): void
    {
        $qif = file_get_contents(__DIR__ . "/KifTestInput.qif");
        $htmlExpected = file_get_contents(__DIR__ . "/KifTestOutput.html");

        $kif = new Kif();

        $htmlGenerated = $kif
          ->parseQif($qif)
          ->generateHtml();

        $this->assertEquals($htmlExpected, $htmlGenerated);
    }
}
