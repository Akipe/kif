<?php

declare(strict_types=1);

use Akipe\Kif\Kif;
use PHPUnit\Framework\TestCase;

final class KifTest extends TestCase
{
    public function testHtmlGeneratedCorresponding(): void
    {
        $input = file_get_contents(__DIR__ . "/KifTest/input.qif");
        $output = file_get_contents(__DIR__ . "/KifTest/output.html");

        $outputGenerated = (new Kif($input))->getHtml();

        $this->assertEquals(
            $output,
            $outputGenerated
        );
    }
}