<?php

namespace Akipe\Kif\Parser\Qif\ElementParser;

use DateTimeImmutable;
use DateTimeInterface;

abstract class QifElementCommonParser
{
  public const ELEMENT_SEPARATOR = "^";
  public const RULE_ATTRIBUTE_DATE = '/^D/i';
  public const RULE_ATTRIBUTE_NOTE = '/^M/i';
  public const RULE_ATTRIBUTE_AMOUNT = '/^T/i';
  public const RULE_ATTRIBUTE_RECIPIENT = '/^P/i';
  public const RULE_ATTRIBUTE_CATEGORY = '/^L/i';
  public const RULE_ATTRIBUTE_ACCOUNT_NAME = '/^N/i';
  public const VALUE_CATEGORY_EMPTY = "(null)";

  /** @var string[] */
  private array $lines;

  public function __construct(
    private readonly string $element,
  )
  {
    $this->setLinesElement($element);
  }

  /**
   * Get all lines of an element
   *
   * @param string $element the element without formating
   * @return void
   */
  private function setLinesElement(string $element): void {
    $lines = explode(PHP_EOL, $element);

    $this->lines = array_filter(array_map(
      fn ($line) => trim($line),
      $lines
    ));
  }

  protected function parseDateAttribute(): DateTimeInterface {
    return DateTimeImmutable::createFromFormat(
      "d/m/Y",
      $this->parseCommonRuleAttribute(
        $this->lines,
        self::RULE_ATTRIBUTE_DATE
      )
    );
  }

  protected function parseNoteAttribute(): string {
    return $this->parseCommonRuleAttribute(
      $this->lines,
      self::RULE_ATTRIBUTE_NOTE
    );
  }

  protected function parseAmountAttribute(): float {
    return $this->castMoney(
      $this->parseCommonRuleAttribute(
        $this->lines,
        self::RULE_ATTRIBUTE_AMOUNT
      )
    );
  }

  protected function parseRecipientAttribute(): string {
    return $this->parseCommonRuleAttribute(
      $this->lines,
      self::RULE_ATTRIBUTE_RECIPIENT
    );
  }

  protected function parseCategoryAttribute(): string {
    $category = $this->parseCommonRuleAttribute(
      $this->lines,
      self::RULE_ATTRIBUTE_CATEGORY
    );

    if ($category == self::VALUE_CATEGORY_EMPTY) return "";

    return $category;
  }

  protected function parseAccountNameAttribute(): string {
    $category = $this->parseCommonRuleAttribute(
      $this->lines,
      self::RULE_ATTRIBUTE_ACCOUNT_NAME
    );

    if ($category == self::RULE_ATTRIBUTE_ACCOUNT_NAME) return "";

    return $category;
  }

  private function parseCommonRuleAttribute(
    array $attributes,
    string $regexRule
  ): string {
    $attributsFound = preg_grep($regexRule, $attributes);

    return strtolower(
      $this->getAttributValue(reset($attributsFound))
    );
  }

  private function getAttributValue(?string $qifLine) {
    return substr($qifLine, 1);
  }

  private function castMoney(string $money): float {
    return (float) str_replace(',', ".", $money);
  }
}
