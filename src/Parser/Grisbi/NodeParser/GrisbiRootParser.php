<?php

namespace Akipe\Kif\Parser\Grisbi\NodeParser;

use SimpleXMLElement;
use Akipe\Kif\Parser\Grisbi\Node\GrisbiRoot;
use Akipe\Kif\Parser\Grisbi\Node\GrisbiParty;
use Akipe\Kif\Parser\Grisbi\Node\GrisbiAccount;
use Akipe\Kif\Parser\Grisbi\Node\GrisbiPaymentType;
use Akipe\Kif\Parser\Grisbi\Node\GrisbiTransaction;

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

    public function __construct(SimpleXMLElement $node)
    {
        parent::__construct($node);

        $this->accounts = [];
        $this->payments = [];
        $this->transactions = [];
        $this->parties = [];

        $this->parseAccounts();
        $this->parsePayments();
        $this->parseTransactions();
        $this->parseParties();
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

        foreach ($paymentsNodes as $accountNode) {
            $payment = (new GrisbiPaymentTypeParser($accountNode))->parse();
            $this->payments[$payment->id] = $payment;
        }

        return $this;
    }

    public function parseTransactions(): self
    {
        $transactionsNodes = $this->getChildNodes(GrisbiTransactionParser::NODE_NAME);

        foreach ($transactionsNodes as $accountNode) {
            $transaction = (new GrisbiTransactionParser($accountNode))->parse();
            $this->transactions[$transaction->id] = $transaction;
        }

        return $this;
    }

    public function parseParties(): self
    {
        $partiesNodes = $this->getChildNodes(GrisbiPartyParser::NODE_NAME);

        foreach ($partiesNodes as $accountNode) {
            $party = (new GrisbiPartyParser($accountNode))->parse();
            $this->parties[$party->id] = $party;
        }

        return $this;
    }
}
