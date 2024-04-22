<?php

namespace Akipe\Kif\Parser\Qif\Node;

class QifAccountInformation
{
    public function __construct(
        public readonly string $name,
    ) {
    }
}
