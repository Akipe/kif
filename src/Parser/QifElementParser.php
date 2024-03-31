<?php

namespace Akipe\Kif\Parser;

use Akipe\Kif\Element\QifTransaction;

class QifElementParser
{
    public const ELEMENT_SEPARATOR = "^";
    public const RULE_ATTRIBUTE_DATE = '/^D/i';
    public const RULE_ATTRIBUTE_NOTE = '/^M/i';
    public const RULE_ATTRIBUTE_AMOUNT = '/^T/i';
    public const RULE_ATTRIBUTE_RECIPIENT = '/^P/i';
    public const RULE_ATTRIBUTE_CATEGORY = '/^L/i';

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
     * @return QifTransaction 
     */
    public function getElement(): QifTransaction {
        return new QifTransaction(
            $this->getDateAttribute($this->lines),
            $this->getNoteAttribute($this->lines),
            $this->getAmountAttribute($this->lines),
            $this->getRecipientAttribute($this->lines),
            $this->getCategoryAttribute($this->lines),
        );
    }

    /**
     * Get all lines of an element
     * 
     * @param string $element the element without formating
     * @return void 
     */
    private function setLinesElement(string $element): void {
        $this->lines = explode(
            PHP_EOL,
            $element,
        );
    }

    private function getDateAttribute(array $attributes): string {
        return $this->getGenericAttribute($attributes, self::RULE_ATTRIBUTE_DATE);
    }

    private function getNoteAttribute(array $attributes): string {
        return $this->getGenericAttribute($attributes, self::RULE_ATTRIBUTE_NOTE);
    }

    private function getAmountAttribute(array $attributes): string {
        return $this->getGenericAttribute($attributes, self::RULE_ATTRIBUTE_AMOUNT);
    }

    private function getRecipientAttribute(array $attributes): string {
        return $this->getGenericAttribute($attributes, self::RULE_ATTRIBUTE_RECIPIENT);
    }

    private function getCategoryAttribute(array $attributes): string {
        return $this->getGenericAttribute($attributes, self::RULE_ATTRIBUTE_CATEGORY);
    }

    private function getGenericAttribute(
        array $attributes,
        string $regexRule
    ): string {
        $attributsFound = preg_grep($regexRule, $attributes);

        return substr(array_shift($attributsFound), 1);
    }
}