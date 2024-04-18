<?php

declare(strict_type=1);

use Akipe\Kif\Element\Transaction;
use Akipe\Kif\Parser\QifElementParser;
use PHPUnit\Framework\TestCase;

final class QifElementParserTest extends TestCase
{
    public function test_transaction_element(): void
    {
        $input = "
            D30/09/2011
            MP
            T-27,40
            PSWEETY
            L(NULL)
        ";
        $desiredResult = new Transaction(
            "30/09/2011",
            "P",
            "-27,40",
            "SWEETY",
            "(NULL)",
        );

        $qifElementParser = new QifElementParser($input);

        $generatedElement = $qifElementParser->getTransactionElement();

        $this->assertEquals($generatedElement, $desiredResult);
    }
}
