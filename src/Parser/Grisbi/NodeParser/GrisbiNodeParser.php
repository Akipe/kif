<?php

namespace Akipe\Kif\Parser\Grisbi\NodeParser;

use DateTimeImmutable;
use Exception;
use SimpleXMLElement;

abstract class GrisbiNodeParser
{
    public function __construct(
        public readonly SimpleXMLElement $node,
    ) {
        if ($this->isNodeIncorrect()) {
            throw new Exception(
                "The parser can only decode " .
                $this->getNodeName() .
                " node, and can not decode "
                . $node->getName() .
                " xml node element"
            );
        }
    }

    private function isNodeIncorrect(): bool
    {
        return $this->getNodeName() != $this->node->getName();
    }

    abstract protected function getNodeName(): string;

    protected function parseIntAttribute(string $name): int
    {
        return intval($this->node->attributes()->{$name});
    }

    protected function parseFloatAttribute(string $name): float
    {
        return floatval($this->node->attributes()->{$name});
    }

    protected function parseDateTimeAttribute(string $name, string $format): DateTimeImmutable
    {
        $dateParsed = DateTimeImmutable::createFromFormat(
            $format,
            $this->parseAttribute($name)
        );

        if (empty($dateParsed)) {
            return new DateTimeImmutable("now");
        }

        return $dateParsed;
    }

    protected function parseAttribute(string $name): string
    {
        return $this->node->attributes()->{$name};
    }

    protected function getChildNodes(string $name): SimpleXMLElement
    {
        return $this->node->{$name};
    }
}
