<?php

namespace Akipe\Kif\Parser\Qif\Element;

use DateTimeInterface;

class QifOpening
{
    public function __construct(
        public readonly DateTimeInterface $date,
        public readonly float $amount,
    ) {
    }
}
