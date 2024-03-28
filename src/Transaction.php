<?php

class Transaction
{
    function __construct(
        public readonly string $date,
        public readonly string $note,
        public readonly string $amount,
        public readonly string $recipient,
        public readonly string $category,
    ){}
}
