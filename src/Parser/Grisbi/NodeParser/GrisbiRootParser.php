<?php

namespace Akipe\Kif\Parser\Grisbi\NodeParser;

use SimpleXMLElement;
use Akipe\Kif\Parser\Grisbi\Node\GrisbiRoot;
use Akipe\Kif\Parser\Grisbi\Node\GrisbiParty;
use Akipe\Kif\Parser\Grisbi\Node\GrisbiAccount;
use Akipe\Kif\Parser\Grisbi\Node\GrisbiCategory;
use Akipe\Kif\Parser\Grisbi\Node\GrisbiPaymentType;
use Akipe\Kif\Parser\Grisbi\Node\GrisbiTransaction;
use Akipe\Kif\Parser\Grisbi\NodeParser\GrisbiCategoryParser;

class GrisbiRootParser extends GrisbiNodeParser
{
    public const NODE_NAME = 'Grisbi';

    /** @var GrisbiAccount[] */
    private array $accounts;
    /** @var GrisbiPaymentType[] */
    private array $payments;
    /** @var GrisbiTransaction[] */
    private array $transactions;
    /** @var GrisbiParty[] */
    private array $parties;
    /** @var GrisbiCategory[] */
    private array $categories;

    public function __construct(SimpleXMLElement $node)
    {
        parent::__construct($node);

        $this->accounts = [];
        $this->payments = [];
        $this->transactions = [];
        $this->parties = [];
        $this->categories = [];

        $this->parseAccounts();
        $this->parsePayments();
        $this->parseTransactions();
        $this->parseParties();
        $this->parseCategories();
    }

    protected function getNodeName(): string
    {
        return self::NODE_NAME;
    }

    public function parse(): GrisbiRoot
    {
        return new GrisbiRoot(
            $this->accounts,
            $this->payments,
            $this->transactions,
            $this->parties,
            $this->categories,
        );
    }

    public function parseAccounts(): self
    {
        $accountsNodes = $this->getChildNodes(GrisbiAccountParser::NODE_NAME);

        foreach ($accountsNodes as $accountNode) {
            $account = (new GrisbiAccountParser($accountNode))->parse();
            $this->accounts[$account->id] = $account;
        }

        return $this;
    }

    public function parsePayments(): self
    {
        $paymentsNodes = $this->getChildNodes(GrisbiPaymentTypeParser::NODE_NAME);

        foreach ($paymentsNodes as $paymentNode) {
            $payment = (new GrisbiPaymentTypeParser($paymentNode))->parse();
            $this->payments[$payment->id] = $payment;
        }

        return $this;
    }

    public function parseTransactions(): self
    {
        $transactionsNodes = $this->getChildNodes(GrisbiTransactionParser::NODE_NAME);

        foreach ($transactionsNodes as $transactionNode) {
            $transaction = (new GrisbiTransactionParser($transactionNode))->parse();
            $this->transactions[$transaction->id] = $transaction;
        }

        return $this;
    }

    public function parseParties(): self
    {
        $partiesNodes = $this->getChildNodes(GrisbiPartyParser::NODE_NAME);

        foreach ($partiesNodes as $partyNode) {
            $party = (new GrisbiPartyParser($partyNode))->parse();
            $this->parties[$party->id] = $party;
        }

        return $this;
    }

    public function parseCategories(): self
    {
        $categoriesNodes = $this->getChildNodes(GrisbiCategoryParser::NODE_NAME);

        foreach ($categoriesNodes as $categoryNode) {
            $category = (new GrisbiCategoryParser($categoryNode))->parse();
            $this->categories[$category->id] = $category;
        }

        return $this;
    }
}
