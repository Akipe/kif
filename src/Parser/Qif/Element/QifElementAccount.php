<?php

namespace Akipe\Kif\Parser\Qif\Element;

class QifElementAccount
{
  public function __construct(
    public readonly string $name,
  ){}
}
