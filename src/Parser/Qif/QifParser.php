<?php

namespace Akipe\Kif\Parser\Qif;

use Akipe\Kif\Parser\Parser;
use Akipe\Kif\Entity\Account;
use Akipe\Kif\Entity\Transaction;
use Akipe\Kif\Parser\Qif\Node\QifOpening;
use Akipe\Kif\Parser\Qif\Node\QifAccountInformation;
use Akipe\Kif\Parser\Qif\NodeParser\QifTransactionParser;
use Akipe\Kif\Parser\Qif\NodeParser\QifOpeningAccountParser;
use Akipe\Kif\Parser\Qif\NodeParser\QifAccountInformationParser;

class QifParser implements Parser
{
    public const INFO_OPENING_TRANSACTION_NODE_RULE = "!Type:Bank";
    public const FIRST_NODE_ACCOUNT_RULE = "!Account";

  /** @var string[] */
    private array $nodes;

    public function __construct(
        private string $content,
    ) {
        $this->setNodes();
    }

    public function getAccount(): Account
    {
        return new Account(
            $this->getAccountNode()->name,
            $this->getOpeningAccountNode()->amount,
            $this->getTransactions(),
        );
    }

  /**
   * Get all transactions
   *
   * @return Transaction[]
   */
    private function getTransactions(): array
    {
        $transactions = [];

      // Parcourir toutes les transactions
        for (
            $index = $this->getFirstTransactionNodeIndex();
            $index < count($this->nodes);
            $index++
        ) {
            $transactions[] =
            (new QifTransactionParser($this->nodes[$index]))
            ->parse();
        }

        $this->sortTransactionsOldestToLatest($transactions);

        return $transactions;
    }

  /**
   *
   * @param Transaction[] $transactions
   * @return void
   */
    private function sortTransactionsOldestToLatest(array &$transactions): void
    {
        uasort(
            $transactions,
            fn ($previousTransaction, $nextTransaction) => $previousTransaction->date <=> $nextTransaction->date
        );

        $transactions = array_values($transactions);
    }

    private function getOpeningAccountNodeIndex(): int
    {
        foreach ($this->nodes as $index => $node) {
            if (str_contains($node, self::INFO_OPENING_TRANSACTION_NODE_RULE)) {
                return $index;
            }
        }

        return 0;
    }

    private function getOpeningAccountNode(): QifOpening
    {
        return (
        new QifOpeningAccountParser(
            $this->nodes[$this->getOpeningAccountNodeIndex()]
        )
        )->parse();
    }

    private function getAccountNode(): QifAccountInformation
    {
        return (
        new QifAccountInformationParser(
            $this->nodes[$this->getFirstAccountNodeIndex()]
        )
        )->parse();
    }

  /**
   * Get first transaction index needed for fetching all next transactions nodes
   *
   * @return int First node transaction index
   */
    private function getFirstTransactionNodeIndex(): int
    {
        return ($this->getOpeningAccountNodeIndex() + 1);
    }

  /**
   * Parsing nodes with node separator
   *
   * @return void
   */
    private function setNodes(): void
    {
        $this->nodes = array_filter(
            explode(QifTransactionParser::NODE_SEPARATOR, trim($this->content)),
            fn($line) => !empty($line) && trim($line) !== ""
        );
    }

    private function getFirstAccountNodeIndex(): int
    {
        foreach ($this->nodes as $index => $node) {
            if (str_contains($node, self::FIRST_NODE_ACCOUNT_RULE)) {
                return $index;
            }
        }

        return 0;
    }
}
