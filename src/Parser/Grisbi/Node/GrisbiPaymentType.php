<?php

namespace Akipe\Kif\Parser\Grisbi\Node;

class GrisbiPaymentType
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly int $accountId,
    ) {
    }
}
