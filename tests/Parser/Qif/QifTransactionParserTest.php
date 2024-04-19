<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Akipe\Kif\Entity\Transaction;
use Akipe\Kif\Parser\Qif\ElementParser\QifTransactionParser;

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
      DateTimeImmutable::createFromFormat("d/m/Y","30/09/2011"),
      "p",
      -27.40,
      "sweety",
      "",
    );

    $parser = new QifTransactionParser($input);
    $transactionParsed = $parser->parse();

    $this->assertEquals($transactionExpected, $transactionParsed);
  }
}
