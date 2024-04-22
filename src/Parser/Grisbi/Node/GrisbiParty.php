<?php

namespace Akipe\Kif\Parser\Grisbi\Node;

class GrisbiParty
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
    ) {
    }
}
