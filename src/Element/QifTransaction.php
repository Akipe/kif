<?php

namespace Akipe\Kif\Element;

use DateTimeImmutable;

class QifTransaction
{
    function __construct(
        public readonly DateTimeImmutable $date,
        public readonly string $note,
        public readonly float $amount,
        public readonly string $recipient,
        public readonly string $category,
    ){}
}
