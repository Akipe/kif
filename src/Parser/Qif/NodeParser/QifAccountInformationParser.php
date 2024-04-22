<?php

namespace Akipe\Kif\Parser\Qif\NodeParser;

use Akipe\Kif\Parser\Qif\Node\QifAccountInformation;

class QifAccountInformationParser extends QifNodeParser
{
    public const NODE_RULE = "!Account";

    public function parse(): QifAccountInformation
    {
        return new QifAccountInformation(
            $this->parseAccountNameAttribute(),
        );
    }

    public static function canParse(string $value): bool
    {
        return str_contains($value, self::NODE_RULE);
    }
}
