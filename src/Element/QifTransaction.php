<?php

namespace Akipe\Kif\Element;

class QifTransaction
{
    function __construct(
        public readonly string $date,
        public readonly string $note,
        public readonly float $amount,
        public readonly string $recipient,
        public readonly string $category,
    ){}
}
