<?php

namespace Akipe\Kif\Parser\Grisbi\NodeParser;

use Akipe\Kif\Parser\Grisbi\Node\GrisbiAccount;

class GrisbiAccountParser extends GrisbiNodeParser
{
    # Specs : https://github.com/grisbi/grisbi/blob/e89f555123a4fa82d69227e74390370605b08561/src/sb_file_save.c#L219
    public const NODE_NAME = 'Account';
    public const ATTRIBUTE_NAME = 'Name';
    public const ATTRIBUTE_ID = 'Id';
    public const ATTRIBUTE_NUMBER = 'Number';
    public const ATTRIBUTE_OWNER = 'Owner';
    public const ATTRIBUTE_KIND = 'Kind';
    public const ATTRIBUTE_CURRENCY = 'Currency';
    public const ATTRIBUTE_ICON_PATH = 'Path_icon';
    public const ATTRIBUTE_BANK = 'Bank';
    public const ATTRIBUTE_BANK_BRANCH_CODE = 'Bank_branch_code';
    public const ATTRIBUTE_BANK_ACCOUNT_NUMBER = 'Bank_account_number';
    public const ATTRIBUTE_KEY = 'Key';
    public const ATTRIBUTE_BANK_ACCOUNT_IBAN = 'Bank_account_IBAN';
    public const ATTRIBUTE_INITIAL_BALANCE = 'Initial_balance';
    public const ATTRIBUTE_MINIMUM_WANTED_BALANCE = 'Minimum_wanted_balance';
    public const ATTRIBUTE_MINIMUM_AUTHORIZED_BALANCE = 'Minimum_authorised_balance';
    public const ATTRIBUTE_CLOSED_ACCOUNT = 'Closed_account';
    public const ATTRIBUTE_SHOW_MARKED = 'Show_marked';
    public const ATTRIBUTE_SHOW_ARCHIVES_LINES = 'Show_archives_lines';
    public const ATTRIBUTE_LINES_PER_TRANSACTION = 'Lines_per_transaction';
    public const ATTRIBUTE_COMMENT = 'Comment';
    public const ATTRIBUTE_OWNER_ADDRESS = 'Owner_address';
    public const ATTRIBUTE_DEFAULT_DEBIT_METHOD = 'Default_debit_method';
    public const ATTRIBUTE_DEFAULT_CREDIT_METHOD = 'Default_credit_method';
    public const ATTRIBUTE_SORT_BY_METHOD = 'Sort_by_method';
    public const ATTRIBUTE_NEUTRALS_INSIDE_METHOD = 'Neutrals_inside_method';
    public const ATTRIBUTE_SORT_ORDER = 'Sort_order';
    public const ATTRIBUTE_ASCENDING_SORT = 'Ascending_sort';
    public const ATTRIBUTE_COLUMN_SORT = 'Column_sort';
    public const ATTRIBUTE_SORTING_KIND_COLUMN = 'Sorting_kind_column';
    public const ATTRIBUTE_BET_USE_BUDGET = 'Bet_use_budget';

    protected function getNodeName(): string
    {
        return self::NODE_NAME;
    }

    public function parse(): GrisbiAccount
    {
        return new GrisbiAccount(
            $this->parseId(),
            $this->parseName(),
            $this->parseInitialBalance(),
            $this->parseComment(),
        );
    }

    private function parseId(): int
    {
        return $this->parseIntAttribute(self::ATTRIBUTE_NUMBER);
    }

    private function parseName(): string
    {
        return $this->parseAttribute(self::ATTRIBUTE_NAME);
    }

    private function parseInitialBalance(): float
    {
        return $this->parseFloatAttribute(self::ATTRIBUTE_INITIAL_BALANCE);
    }

    private function parseComment(): string
    {
        return $this->parseAttribute(self::ATTRIBUTE_COMMENT);
    }
}
