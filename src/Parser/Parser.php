<?php

namespace Akipe\Kif\Parser;

use Akipe\Kif\Entity\Account;

interface Parser
{
    public function getAccount(): Account;
}
