<?php

namespace Akipe\Kif\Parser\Qif\NodeParser;

use Akipe\Kif\Parser\Qif\Node\QifAccountInformation;

class QifAccountInformationParser extends QifNodeParser
{
    public function parse(): QifAccountInformation
    {
        return new QifAccountInformation(
            $this->parseAccountNameAttribute(),
        );
    }
}
