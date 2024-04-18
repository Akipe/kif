<?php

namespace Akipe\Kif\Parser\Qif;

use DateTimeImmutable;
use Akipe\Kif\Entity\Transaction;
use Akipe\Kif\Parser\Qif\Element\QifElementAccount;

class QifTransactionParser
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
  ) {
    $this->setLinesElement($element);
  }

  /**
   * Get parsed element with all his attributes
   *
   * @return Transaction
   */
  public function parse(): Transaction {
    return new Transaction(
      $this->parseDateAttribute(),
      $this->parseNoteAttribute(),
      $this->parseAmountAttribute(),
      $this->parseRecipientAttribute(),
      $this->parseCategoryAttribute(),
    );
  }

  public function parseAccountElement(): QifElementAccount {
    return new QifElementAccount(
      $this->parseAccountNameAttribute(),
    );
  }

  /**
   * Get all lines of an element
   *
   * @param string $element the element without formating
   * @return void
   */
  private function setLinesElement(string $element): void {
    $lines = explode(PHP_EOL, $element);

    $this->lines = array_map(
      fn ($line) => trim($line),
      $lines
    );
  }

  private function parseDateAttribute(): DateTimeImmutable {
    return DateTimeImmutable::createFromFormat(
      "d/m/Y",
      $this->parseCommonRuleAttribute($this->lines, self::RULE_ATTRIBUTE_DATE)
    );
  }

  private function parseNoteAttribute(): string {
    return $this->parseCommonRuleAttribute($this->lines, self::RULE_ATTRIBUTE_NOTE);
  }

  private function parseAmountAttribute(): float {
    return $this->castMoney($this->parseCommonRuleAttribute($this->lines, self::RULE_ATTRIBUTE_AMOUNT));
  }

  private function parseRecipientAttribute(): string {
    return $this->parseCommonRuleAttribute($this->lines, self::RULE_ATTRIBUTE_RECIPIENT);
  }

  private function parseCategoryAttribute(): string {
    $category = $this->parseCommonRuleAttribute($this->lines, self::RULE_ATTRIBUTE_CATEGORY);

    if ($category == self::VALUE_CATEGORY_EMPTY) return "";

    return $category;
  }

  private function parseAccountNameAttribute(): string {
    $category = $this->parseCommonRuleAttribute($this->lines, self::RULE_ATTRIBUTE_ACCOUNT_NAME);

    if ($category == self::RULE_ATTRIBUTE_ACCOUNT_NAME) return "";

    return $category;
  }

  private function parseCommonRuleAttribute(
    array $attributes,
    string $regexRule
  ): string {
    $attributsFound = preg_grep($regexRule, $attributes);

    return strtolower($this->getAttributValue(array_shift($attributsFound), 1));
  }

  private function getAttributValue(?string $qifLine) {
    return substr($qifLine, 1);
  }

  private function castMoney(string $money): float {
    return (float) str_replace(',', ".", $money);
  }
}
