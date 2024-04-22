<?php

namespace Akipe\Kif\Parser\Grisbi\NodeParser;

use Akipe\Kif\Parser\Grisbi\Node\GrisbiParty;

class GrisbiPartyParser extends GrisbiNodeParser
{
    # Specs : https://github.com/grisbi/grisbi/blob/e89f555123a4fa82d69227e74390370605b08561/src/gsb_file_save.c#L1264
    public const NODE_NAME = 'Party';
    public const ATTRIBUTE_NUMBER = 'Nb';
    public const ATTRIBUTE_NAME = 'Na';
    public const ATTRIBUTE_DESCRIPTION = 'Txt';
    public const ATTRIBUTE_SEARCH_STRING = 'Search';
    public const ATTRIBUTE_IGNORE_CASE = 'IgnCase';
    public const ATTRIBUTE_USE_REGEX = 'UseRegex';

    protected function getNodeName(): string
    {
        return self::NODE_NAME;
    }

    public function parse(): GrisbiParty
    {
        return new GrisbiParty(
            $this->parseId(),
            $this->parseName(),
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
}
