<?php

namespace Akipe\Kif\Parser\Grisbi\Node;

use DateTimeInterface;

class GrisbiTransaction
{
    public function __construct(
        public readonly int $id,
        public readonly DateTimeInterface $date,
        public readonly int $accountId,
        public readonly float $amount,
        public readonly int $partyId,
        public readonly string $categoryId,
        public readonly string $notes,
    ) {
    }
}
