<?php

declare(strict_types=1);

namespace Akipe\Kif\Test\KifTest;

use Akipe\Kif\Kif;
use PHPUnit\Framework\TestCase;
use Akipe\Kif\Parser\Qif\QifParser;
use Akipe\Kif\ViewGenerator\Html\HtmlGenerator;
use Exception;

final class KifTest extends TestCase
{
    private const INPUT_FILE_PATH = __DIR__ . "/KifTestInput.qif";
    private const EXPECTED_RESULT_FILE_PATH = __DIR__ . "/KifTestOutput.html";

    public function test_qif_to_html_is_result_expected(): void
    {
        $qif = file_get_contents(self::INPUT_FILE_PATH);

        if (empty($qif)) {
            throw new Exception("Can't load qif data at " . self::INPUT_FILE_PATH);
        }

        $htmlExpected = file_get_contents(self::EXPECTED_RESULT_FILE_PATH);

        $kif = new Kif();

        $qifParser = new QifParser($qif);
        $htmlGenerator = new HtmlGenerator();

        $htmlGenerated = $kif
          ->parse($qifParser)
          ->generateView($htmlGenerator);

        $this->assertEquals($htmlExpected, $htmlGenerated);
    }
}
