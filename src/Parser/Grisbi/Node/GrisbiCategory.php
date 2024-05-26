<?php

namespace Akipe\Kif\Parser\Grisbi\Node;

class GrisbiCategory
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly GrisbiCategoryType $type,
    ) {
    }
}
