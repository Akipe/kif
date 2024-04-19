<?php

declare(strict_types=1);

use Akipe\Kif\Entity\Account;
use PHPUnit\Framework\TestCase;
use Akipe\Kif\Entity\Transaction;
use Akipe\Kif\Parser\Qif\QifParser;

final class QifParserTest extends TestCase
{
  public function test_expected_account_parsed(): void
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

    $listTransactions = [];
    $listTransactions[] = new Transaction(
      DateTimeImmutable::createFromFormat("d/m/Y","22/01/2011"),
      "p",
      200.00,
      "virement",
      "",
    );
    $listTransactions[] = new Transaction(
      DateTimeImmutable::createFromFormat("d/m/Y","27/09/2011"),
      "p",
      -29.00,
      "caffe",
      "",
    );
    $listTransactions[] = new Transaction(
      DateTimeImmutable::createFromFormat("d/m/Y","30/09/2011"),
      "p",
      -27.40,
      "sweety",
      "",
    );
    $listTransactions[] = new Transaction(
      DateTimeImmutable::createFromFormat("d/m/Y","03/10/2011"),
      "p",
      -60.10,
      "pharmacie",
      "",
    );

    $accountExpected = new Account(
      "thomas - banque cc",
      0.0,
      $listTransactions,
    );

    $parser = new QifParser($input);
    $account = $parser->getAccount();

    $this->assertEquals($accountExpected, $account);
  }
}
