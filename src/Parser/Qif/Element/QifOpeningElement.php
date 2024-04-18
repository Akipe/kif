<?php

namespace Akipe\Kif\Parser\Qif\Element;

use DateTimeInterface;

class QifOpeningElement
{
  public function __construct(
    public readonly DateTimeInterface $date,
    public readonly string $amount,
  ){}
}
