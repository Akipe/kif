<?php

namespace Akipe\Kif;

use Akipe\Kif\Parser\Parser;
use Akipe\Kif\Entity\Account;
use Akipe\Kif\ViewGenerator\ViewGenerator;

class Kif
{
    private Account $account;

    public function parse(Parser $parser): self
    {
        $this->account = $parser->getAccount();

        return $this;
    }

    public function generateView(ViewGenerator $viewGenerator): string
    {
        return $viewGenerator
        ->load($this->account)
        ->generate();
    }
}
