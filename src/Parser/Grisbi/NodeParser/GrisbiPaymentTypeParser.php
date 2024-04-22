<?php

namespace Akipe\Kif\Parser\Grisbi\NodeParser;

use Akipe\Kif\Parser\Grisbi\Node\GrisbiPaymentType;

class GrisbiPaymentTypeParser extends GrisbiNodeParser
{
    # Specs : https://github.com/grisbi/grisbi/blob/e89f555123a4fa82d69227e74390370605b08561/src/gsb_file_save.c#L1312
    public const NODE_NAME = 'Payment';
    public const ATTRIBUTE_NUMBER = 'Number';
    public const ATTRIBUTE_NAME = 'Name';
    public const ATTRIBUTE_SIGN = 'Sign';
    public const ATTRIBUTE_SHOW_ENTRY = 'Show_entry';
    public const ATTRIBUTE_AUTOMATIC_NUMBERING = 'Automatic_number';
    public const ATTRIBUTE_LAST_NUMBER = 'Current_number';
    public const ATTRIBUTE_ACCOUNT_NUMBER = 'Account';

    protected function getNodeName(): string
    {
        return self::NODE_NAME;
    }

    public function parse(): GrisbiPaymentType
    {
        return new GrisbiPaymentType(
            $this->parseNumber(),
            $this->parseName(),
            $this->parseAccountNumber(),
        );
    }

    public function parseNumber(): int
    {
        return $this->parseIntAttribute(self::ATTRIBUTE_NUMBER);
    }

    public function parseName(): string
    {
        return $this->parseAttribute(self::ATTRIBUTE_NAME);
    }

    public function parseAccountNumber(): int
    {
        return $this->parseIntAttribute(self::ATTRIBUTE_ACCOUNT_NUMBER);
    }
}
