<?php

namespace Akipe\Kif\ViewGenerator;

use Akipe\Kif\Entity\Account;

interface ViewGenerator
{
    public function load(Account $account): self;
    public function generate(): string;
}
