<?php

namespace Akipe\Kif\Parser\Qif\Node;

use DateTimeInterface;

class QifOpening
{
    public function __construct(
        public readonly DateTimeInterface $date,
        public readonly float $amount,
    ) {
    }
}
