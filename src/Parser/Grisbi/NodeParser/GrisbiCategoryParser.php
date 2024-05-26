<?php

namespace Akipe\Kif\Parser\Grisbi\NodeParser;

use Akipe\Kif\Parser\Grisbi\Node\GrisbiCategory;
use Akipe\Kif\Parser\Grisbi\Node\GrisbiParty;
use Akipe\Kif\Parser\Grisbi\Node\GrisbiCategoryType;

class GrisbiCategoryParser extends GrisbiNodeParser
{
    # Specs : https://github.com/grisbi/grisbi/blob/e89f555123a4fa82d69227e74390370605b08561/src/gsb_file_save.c#L2190
    public const NODE_NAME = 'Category';
    public const ATTRIBUTE_NUMBER = 'Nb';
    public const ATTRIBUTE_NAME = 'Na';
    public const ATTRIBUTE_TYPE = 'Kd';

    protected function getNodeName(): string
    {
        return self::NODE_NAME;
    }

    public function parse(): GrisbiCategory
    {
        return new GrisbiCategory(
            $this->parseId(),
            $this->parseName(),
            $this->parseType(),
        );
    }

    public function parseId(): int
    {
        return $this->parseIntAttribute(self::ATTRIBUTE_NUMBER);
    }

    public function parseName(): string
    {
        return $this->parseAttribute(self::ATTRIBUTE_NAME);
    }

    public function parseType(): GrisbiCategoryType
    {
        return GrisbiCategoryType::from(
            $this->parseIntAttribute(self::ATTRIBUTE_TYPE)
        );
    }
}
