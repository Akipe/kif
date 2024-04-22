<?php

namespace Akipe\Kif\Parser\Qif\NodeParser;

use Akipe\Kif\Parser\Qif\Node\QifOpening;

class QifOpeningAccountParser extends QifNodeParser
{
    public const NODE_RULE = "!Type:Bank";

    public function parse(): QifOpening
    {
        return new QifOpening(
            $this->parseDateAttribute(),
            $this->parseAmountAttribute(),
        );
    }

    public static function canParse(string $value): bool
    {
        return str_contains($value, self::NODE_RULE);
    }
}
