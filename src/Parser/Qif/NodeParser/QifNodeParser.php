<?php

namespace Akipe\Kif\Parser\Qif\NodeParser;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;

abstract class QifNodeParser
{
    public const NODE_SEPARATOR = "^";
    public const RULE_ATTRIBUTE_DATE = '/^D/i';
    public const RULE_ATTRIBUTE_NOTE = '/^M/i';
    public const RULE_ATTRIBUTE_AMOUNT = '/^T/i';
    public const RULE_ATTRIBUTE_RECIPIENT = '/^P/i';
    public const RULE_ATTRIBUTE_CATEGORY = '/^L/i';
    public const RULE_ATTRIBUTE_ACCOUNT_NAME = '/^N/i';
    public const VALUE_CATEGORY_EMPTY = "(null)";
    public const DATE_FORMAT = 'd/m/Y';

  /** @var string[] */
    private array $lines;

    public function __construct(
        string $node,
    ) {
        $this->setNodeLines($node);
    }

  /**
   * Get all lines of a node
   *
   * @param string $node the node without formating
   * @return void
   */
    private function setNodeLines(string $node): void
    {
        $lines = explode(PHP_EOL, $node);

        $this->lines = array_filter(array_map(
            fn ($line) => trim($line),
            $lines
        ));
    }

    protected function parseDateAttribute(): DateTimeInterface
    {
        $dateParsed = DateTimeImmutable::createFromFormat(
            self::DATE_FORMAT,
            $this->parsePatternRuleAttribute(
                $this->lines,
                self::RULE_ATTRIBUTE_DATE
            )
        );

        if (empty($dateParsed)) {
            throw new Exception(
                "Date can't be parsed with the rule " .
                self::RULE_ATTRIBUTE_DATE .
                " for node : " . PHP_EOL .
                implode(PHP_EOL, $this->lines)
            );
        }

        return $dateParsed;
    }

    protected function parseNoteAttribute(): string
    {
        return $this->parsePatternRuleAttribute(
            $this->lines,
            self::RULE_ATTRIBUTE_NOTE
        );
    }

    protected function parseAmountAttribute(): float
    {
        return $this->castMoney(
            $this->parsePatternRuleAttribute(
                $this->lines,
                self::RULE_ATTRIBUTE_AMOUNT
            )
        );
    }

    protected function parseRecipientAttribute(): string
    {
        return $this->parsePatternRuleAttribute(
            $this->lines,
            self::RULE_ATTRIBUTE_RECIPIENT
        );
    }

    protected function parseCategoryAttribute(): string
    {
        $category = $this->parsePatternRuleAttribute(
            $this->lines,
            self::RULE_ATTRIBUTE_CATEGORY
        );

        if ($category == self::VALUE_CATEGORY_EMPTY) {
            return "";
        }

        return $category;
    }

    protected function parseAccountNameAttribute(): string
    {
        $category = $this->parsePatternRuleAttribute(
            $this->lines,
            self::RULE_ATTRIBUTE_ACCOUNT_NAME
        );

        if ($category == self::RULE_ATTRIBUTE_ACCOUNT_NAME) {
            return "";
        }

        return $category;
    }

  /**
   *
   * @param string[] $lines
   * @param string $regexRule
   * @return string
   */
    private function parsePatternRuleAttribute(
        array $lines,
        string $regexRule
    ): string {
        $attributsFound = preg_grep($regexRule, $lines);

        if (empty($attributsFound)) {
            throw new Exception(
                "No attributs found with the rule " .
                $regexRule .
                " in lines " .
                implode(PHP_EOL, $lines)
            );
        }

        return strtolower(
            $this->getAttributeValue(reset($attributsFound))
        );
    }

    private function getAttributeValue(string $qifLine): string
    {
        return substr($qifLine, 1);
    }

    private function castMoney(string $money): float
    {
        return (float) str_replace(',', ".", $money);
    }
}
