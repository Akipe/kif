<?php

declare(strict_types=1);

namespace Akipe\Kif\Test\Qif;

use PHPUnit\Framework\TestCase;
use Akipe\Kif\Entity\Transaction;
use Akipe\Lib\Test\DateTimeFormatGeneration;
use Akipe\Kif\Parser\Qif\NodeParser\QifTransactionParser;

final class QifTransactionParserTest extends TestCase
{
    public function test_expected_transaction_parsed(): void
    {
        $input = "
            D30/09/2011
            MP
            T-27,40
            PSWEETY
            L(NULL)
        ";

        $transactionExpected = new Transaction(
            DateTimeFormatGeneration::get("d/m/Y", "30/09/2011"),
            "p",
            -27.40,
            "sweety",
            "",
        );

        $transactionParsed = (new QifTransactionParser($input))->parse();

        // $this->assertEquals($transactionExpected, 0);
        $this->assertEquals($transactionExpected, $transactionParsed);
    }
}
