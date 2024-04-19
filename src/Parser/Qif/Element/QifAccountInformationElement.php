<?php

namespace Akipe\Kif\Parser\Qif\Element;

class QifAccountInformationElement
{
  public function __construct(
    public readonly string $name,
  ){}
}
