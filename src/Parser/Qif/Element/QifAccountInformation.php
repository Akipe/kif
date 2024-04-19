<?php

namespace Akipe\Kif\Parser\Qif\Element;

class QifAccountInformation
{
    public function __construct(
        public readonly string $name,
    ) {
    }
}
