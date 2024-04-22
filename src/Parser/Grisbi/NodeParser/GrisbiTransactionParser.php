<?php

namespace Akipe\Kif\Parser\Grisbi\NodeParser;

use DateTimeImmutable;
use DateTimeInterface;
use Akipe\Kif\Parser\Grisbi\Node\GrisbiTransaction;

class GrisbiTransactionParser extends GrisbiNodeParser
{
    # Specs : https://github.com/grisbi/grisbi/blob/e89f555123a4fa82d69227e74390370605b08561/src/gsb_file_save.c#L1662
    public const NODE_NAME = 'Transaction';
    public const ATTRIBUTE_ACCOUNT_ID = 'Ac';
    public const ATTRIBUTE_NUMBER = 'Nb';
    public const ATTRIBUTE_ID = 'Id';
    public const ATTRIBUTE_DATE = 'Dt';
    public const ATTRIBUTE_DATE_UNUSED = 'Dv';
    public const ATTRIBUTE_CURRENCY_ID = 'Cu';
    public const ATTRIBUTE_AMOUNT = 'Am';
    public const ATTRIBUTE_CHANGE_BETWEEN_TRANSACTION_ID = 'Exb';
    public const ATTRIBUTE_EXCHANGE_RATE = 'Exr';
    public const ATTRIBUTE_EXCHANGE_FEES = 'Exf';
    public const ATTRIBUTE_PARTY_ID = 'Pa';
    public const ATTRIBUTE_CATEGORY_ID = 'Ca';
    public const ATTRIBUTE_SUB_CATEGORY_ID = 'Sca';
    public const ATTRIBUTE_SPIT_OF_TRANSACTION = 'Br';
    public const ATTRIBUTE_NOTES = 'No';
    public const ATTRIBUTE_PAYMENT_METHOD = 'Pn';
    public const ATTRIBUTE_PAYMENT_METHOD_CONTENT = 'Pc';
    public const ATTRIBUTE_MARKED = 'Ma';
    public const ATTRIBUTE_ARCHIVE_NUMBER = 'Ar';
    public const ATTRIBUTE_AUTOMATIC = 'Au';
    public const ATTRIBUTE_RECONCILE_NUMBER = 'Re';
    public const ATTRIBUTE_FINANCIAL_YEAR_NUMBER = 'Fi';
    public const ATTRIBUTE_BUDGETARY_NUMBER = 'Bu';
    public const ATTRIBUTE_SUB_BUDGETARY_NUMBER = 'Sbu';
    public const ATTRIBUTE_VOUCHER = 'Vo';
    public const ATTRIBUTE_BANK_REFERENCES = 'Ba';
    public const ATTRIBUTE_CONTRACT_TRANSACTION_NUMBER = 'Trt';
    public const ATTRIBUTE_MOTHER_TRANSACTION_NUMBER = 'Mo';
    public const DATE_FORMAT = 'd/m/Y';

    protected function getNodeName(): string
    {
        return self::NODE_NAME;
    }

    public function parse(): GrisbiTransaction
    {
        return new GrisbiTransaction(
            $this->parseId(),
            $this->parseDateAttribute(),
            $this->parseAccountId(),
            $this->parseAmount(),
            $this->parsePartyId(),
            $this->parseNotes(),
        );
    }

    private function parseId(): int
    {
        return $this->parseIntAttribute(self::ATTRIBUTE_NUMBER);
    }

    private function parseDateAttribute(): DateTimeInterface
    {
        return $this->parseDateTimeAttribute(self::ATTRIBUTE_DATE, self::DATE_FORMAT);
    }

    private function parseAccountId(): int
    {
        return $this->parseIntAttribute(self::ATTRIBUTE_ACCOUNT_ID);
    }

    private function parseAmount(): float
    {
        return $this->parseFloatAttribute(self::ATTRIBUTE_AMOUNT);
    }

    private function parsePartyId(): int
    {
        return $this->parseIntAttribute(self::ATTRIBUTE_PARTY_ID);
    }

    private function parseNotes(): string
    {
        return $this->parseAttribute(self::ATTRIBUTE_NOTES);
    }
}
