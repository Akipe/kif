<?php

declare(strict_types=1);

use Akipe\Kif\Element\QifElementTransaction;
use Akipe\Kif\Parser\QifParser;
use PHPUnit\Framework\TestCase;

final class QifParserTest extends TestCase
{
    public function test_generate_list_transactions(): void
    {
        $input = "
            !Account
            NThomas - Banque CC
            ^
            !Type:Bank
            D22/01/2011
            T0,00
            CX
            POpening Balance
            L[Thomas - Banque CC]
            ^
            D22/01/2011
            MP
            T200,00
            PVIREMENT
            L(NULL)
            ^
            D27/09/2011
            MP
            T-29,00
            PCAFFE
            L(NULL)
            ^
            D30/09/2011
            MP
            T-27,40
            PSWEETY
            L(NULL)
            ^
            D03/10/2011
            MP
            T-60,10
            PPHARMACIE
            L(NULL)
            ^
        ";

        $desiredResult = [];
        $desiredResult[] = new QifElementTransaction(
            "22/01/2011",
            "",
            "0,00",
            "Opening Balance",
            "[Thomas - Banque CC]",
        );
        $desiredResult[] = new QifElementTransaction(
            "22/01/2011",
            "P",
            "200,00",
            "VIREMENT",
            "(NULL)",
        );
        $desiredResult[] = new QifElementTransaction(
            "27/09/2011",
            "P",
            "-29,00",
            "CAFFE",
            "(NULL)",
        );
        $desiredResult[] = new QifElementTransaction(
            "30/09/2011",
            "P",
            "-27,40",
            "SWEETY",
            "(NULL)",
        );
        $desiredResult[] = new QifElementTransaction(
            "03/10/2011",
            "P",
            "-60,10",
            "PHARMACIE",
            "(NULL)",
        );


        $parser = new QifParser($input);
        $transactions = $parser->getTransactions();

        $this->assertEquals($transactions, $desiredResult);
    }
}