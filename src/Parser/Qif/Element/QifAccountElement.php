<?php

namespace Akipe\Kif\Parser\Qif\Element;

class QifAccountElement
{
  public function __construct(
    public readonly string $name,
  ){}
}
