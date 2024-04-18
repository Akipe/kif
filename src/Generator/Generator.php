<?php

namespace Akipe\Kif\Generator;

use Akipe\Kif\Entity\Account;

interface Generator
{
  public function load(Account $account): self;
  public function generate(): string;
}
