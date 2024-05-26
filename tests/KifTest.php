<?php

declare(strict_types=1);

namespace Akipe\Kif\Test\KifTest;

use Exception;
use Akipe\Kif\Kif;
use PHPUnit\Framework\TestCase;
use Akipe\Kif\Parser\Qif\QifParser;
use Akipe\Kif\Parser\Grisbi\GrisbiParser;
use Akipe\Kif\ViewGenerator\Html\HtmlGenerator;

final class KifTest extends TestCase
{
    private const INPUT_QIF_FILE_PATH = __DIR__ . "/assets/KifTest/input_qif.qif";
    private const EXPECTED_QIF_RESULT_FILE_PATH = __DIR__ . "/assets/KifTest/output_expected_qif.html";
    private const INPUT_GRISBI_FILE_PATH = __DIR__ . "/assets/KifTest/input_grisbi.gsb";
    private const INPUT_GRISBI_ACCOUNT_NAME = "Caisse";
    private const EXPECTED_GRISBI_RESULT_FILE_PATH = __DIR__ . "/assets/KifTest/output_expected_grisbi.html";

    public function test_qif_to_html_is_result_expected(): void
    {
        $qif = file_get_contents(self::INPUT_QIF_FILE_PATH);

        if (empty($qif)) {
            throw new Exception("Can't load qif data at " . self::INPUT_QIF_FILE_PATH);
        }

        $htmlExpected = file_get_contents(self::EXPECTED_QIF_RESULT_FILE_PATH);

        if (empty($htmlExpected)) {
            throw new Exception("Can't load html result data at " . self::EXPECTED_QIF_RESULT_FILE_PATH);
        }

        $kif = new Kif();

        $qifParser = new QifParser($qif);
        $htmlGenerator = new HtmlGenerator();

        $htmlGenerated = $kif
          ->parse($qifParser)
          ->generateView($htmlGenerator);

        // file_put_contents(__DIR__ . "/output_qif.html", $htmlGenerated);

        $this->assertEquals($htmlExpected, $htmlGenerated);
    }

    public function test_grisbi_to_html_is_result_expected(): void
    {
        $grisbi = file_get_contents(self::INPUT_GRISBI_FILE_PATH);

        if (empty($grisbi)) {
            throw new Exception("Can't load grisbi data at " . self::INPUT_GRISBI_FILE_PATH);
        }

        $htmlExpected = file_get_contents(self::EXPECTED_GRISBI_RESULT_FILE_PATH);

        if (empty($htmlExpected)) {
            throw new Exception("Can't load html result data at " . self::EXPECTED_GRISBI_RESULT_FILE_PATH);
        }

        $kif = new Kif();

        $grisbiParser = new GrisbiParser($grisbi, self::INPUT_GRISBI_ACCOUNT_NAME);
        $htmlGenerator = new HtmlGenerator();

        $htmlGenerated = $kif
          ->parse($grisbiParser)
          ->generateView($htmlGenerator);

        // file_put_contents(__DIR__ . "/output_grisbi.html", $htmlGenerated);

        $this->assertEquals($htmlExpected, $htmlGenerated);
    }
}
