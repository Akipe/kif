<?php

namespace Akipe\Kif\Parser\Qif\NodeParser;

use Akipe\Kif\Parser\Qif\Node\QifOpening;

class QifOpeningAccountParser extends QifNodeParser
{
    public function parse(): QifOpening
    {
        return new QifOpening(
            $this->parseDateAttribute(),
            $this->parseAmountAttribute(),
        );
    }
}
