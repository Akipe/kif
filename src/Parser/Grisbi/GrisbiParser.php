<?php

namespace Akipe\Kif\Parser\Grisbi;

use Exception;
use SimpleXMLElement;
use Akipe\Kif\Parser\Parser;
use Akipe\Kif\Entity\Account;
use Akipe\Kif\Entity\Transaction;
use Akipe\Kif\Service\TransactionSorter;
use Akipe\Kif\Parser\Grisbi\Node\GrisbiRoot;
use Akipe\Kif\Parser\Grisbi\Node\GrisbiParty;
use Akipe\Kif\Parser\Grisbi\Node\GrisbiAccount;
use Akipe\Kif\Parser\Grisbi\Node\GrisbiCategory;
use Akipe\Kif\Parser\Grisbi\Node\GrisbiTransaction;
use Akipe\Kif\Parser\Grisbi\NodeParser\GrisbiRootParser;

class GrisbiParser implements Parser
{
    public readonly SimpleXMLElement $rootNode;

    public function __construct(
        public readonly string $content,
        private string $accountNameToFetch,
    ) {
        $rootNode = simplexml_load_string($content)
            or die("Error: cannot create XML Grisbi object");

        if (empty($rootNode)) {
            throw new Exception("Can process content as XML nodes :" . PHP_EOL . $content);
        }

        $this->rootNode = $rootNode;
    }

    public function getAccount(): Account
    {
        $rootNode = $this->getGrisbiRootNode();
        $accountNode = $this->getSpecificAccount($this->accountNameToFetch, $rootNode);

        if (empty($accountNode)) {
            throw new Exception("Can't find account named " . $this->accountNameToFetch);
        }

        $transactions = $this->getTransactions($accountNode, $rootNode);

        return new Account(
            $accountNode->name,
            $accountNode->initialBalance,
            $transactions
        );
    }

    /**
     * Get all transactions
     *
     * @return Transaction[]
     */
    private function getTransactions(GrisbiAccount $accountNode, GrisbiRoot $rootNode): array
    {
        $transactionsNodes = $this->getTransactionsLinkedToAccount($accountNode, $rootNode->transactions);

        /** @var Transaction[] */
        $transactions = [];

        foreach ($transactionsNodes as $transactionNode) {
            $partyName = $this->getPartyLinkedToTransaction($transactionNode, $rootNode->parties)->name ?? "";
            $categoryName = $this->getCategoryLinkedToTransaction($transactionNode, $rootNode->categories)->name ?? "";

            $transactions[] = new Transaction(
                $transactionNode->date,
                $categoryName,
                $transactionNode->amount,
                $partyName,
                "category",
            );
        }

        TransactionSorter::oldestToLatest($transactions);

        return $transactions;
    }

    private function getSpecificAccount(string $accountName, GrisbiRoot $nodeRoot): ?GrisbiAccount
    {
        foreach ($nodeRoot->accounts as $account) {
            if (strtolower(trim($account->name)) == strtolower(trim($accountName))) {
                return $account;
            }
        }

        return null;
    }

    /**
     *
     * @param GrisbiAccount $account
     * @param GrisbiTransaction[] $transactions
     * @return GrisbiTransaction[]
     */
    private function getTransactionsLinkedToAccount(GrisbiAccount $account, array $transactions): array
    {
        /** @var GrisbiTransaction[] */
        $transactionsLinked = [];
        foreach ($transactions as $transaction) {
            if ($transaction->accountId == $account->id) {
                $transactionsLinked[] = $transaction;
            }
        }

        return $transactionsLinked;
    }

    /**
     *
     * @param GrisbiTransaction $transaction
     * @param GrisbiParty[] $parties
     * @return GrisbiParty
     */
    private function getPartyLinkedToTransaction(GrisbiTransaction $transaction, array $parties): ?GrisbiParty
    {
        foreach ($parties as $party) {
            if ($party->id == $transaction->partyId) {
                return $party;
            }
        }

        return null;
    }

    /**
     *
     * @param GrisbiTransaction $transaction
     * @param GrisbiCategory[] $categories
     * @return null|GrisbiCategory
     */
    private function getCategoryLinkedToTransaction(GrisbiTransaction $transaction, array $categories): ?GrisbiCategory
    {
        foreach ($categories as $category) {
            if ($category->id == $transaction->categoryId) {
                return $category;
            }
        }

        return null;
    }

    private function getGrisbiRootNode(): GrisbiRoot
    {
        $parser = new GrisbiRootParser($this->rootNode);

        return $parser->parse();
    }
}
