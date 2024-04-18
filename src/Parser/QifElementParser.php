<?php

namespace Akipe\Kif\Parser;

use Akipe\Kif\Element\QifElementAccount;
use Akipe\Kif\Element\QifElementTransaction;
use DateTimeImmutable;

class QifElementParser
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
   * @return QifElementTransaction
   */
  public function getTransactionElement(): QifElementTransaction {
    return new QifElementTransaction(
      $this->getDateAttribute(),
      $this->getNoteAttribute(),
      $this->getAmountAttribute(),
      $this->getRecipientAttribute(),
      $this->getCategoryAttribute(),
    );
  }

  public function getAccountElement(): QifElementAccount {
    return new QifElementAccount(
      $this->getAccountNameAttribute(),
    );
  }

  /**
   * Get all lines of an element
   *
   * @param string $element the element without formating
   * @return void
   */
  private function setLinesElement(string $element): void {
    $lines = explode(
      PHP_EOL,
      $element,
    );

    $this->lines = array_map(function ($line) { return trim($line); }, $lines);
  }

  private function getDateAttribute(): DateTimeImmutable {
    return DateTimeImmutable::createFromFormat(
      "d/m/Y",
      $this->getGenericAttribute($this->lines, self::RULE_ATTRIBUTE_DATE)
    );
  }

  private function getNoteAttribute(): string {
    return $this->getGenericAttribute($this->lines, self::RULE_ATTRIBUTE_NOTE);
  }

  private function getAmountAttribute(): float {
    return $this->castMoney($this->getGenericAttribute($this->lines, self::RULE_ATTRIBUTE_AMOUNT));
  }

  private function getRecipientAttribute(): string {
    return $this->getGenericAttribute($this->lines, self::RULE_ATTRIBUTE_RECIPIENT);
  }

  private function getCategoryAttribute(): string {
    $category = $this->getGenericAttribute($this->lines, self::RULE_ATTRIBUTE_CATEGORY);

    if ($category == self::VALUE_CATEGORY_EMPTY) return "";

    return $category;
  }

  private function getAccountNameAttribute(): string {
    $category = $this->getGenericAttribute($this->lines, self::RULE_ATTRIBUTE_ACCOUNT_NAME);

    if ($category == self::RULE_ATTRIBUTE_ACCOUNT_NAME) return "";

    return $category;
  }

  private function getGenericAttribute(
    array $attributes,
    string $regexRule
  ): string {
    $attributsFound = preg_grep($regexRule, $attributes);

    return strtolower(substr(array_shift($attributsFound), 1));
  }

  private function castMoney(string $money): float {
    return (float) str_replace(',', ".", $money);
  }
}
