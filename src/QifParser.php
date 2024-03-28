<?php

include_once "Transaction.php";

class QifParser
{
    public const BEGIN_TRANSACTION = "!Type:Bank";
    public const END_ELEMENT = "^";
    public const RULE_ATTRIBUTE_DATE = '/^D/i';
    public const RULE_ATTRIBUTE_NOTE = '/^M/i';
    public const RULE_ATTRIBUTE_AMOUNT = '/^T/i';
    public const RULE_ATTRIBUTE_RECIPIENT = '/^P/i';
    public const RULE_ATTRIBUTE_CATEGORY = '/^L/i';

    private array $elements;

    public function __construct(
        private string $content,
    ) {
        $this->setElements();
    }

    public function getTransactions(): array {
        $listTransactions = [];

        // Trouver la position de la première transaction
        $indexTransactionBegin = -1;

        foreach($this->getElements() as $index => $element) {
            if (str_contains($element, self::BEGIN_TRANSACTION)) {
                $indexTransactionBegin = $index;
                break;
            }
        }

        // Parcourir toutes les transactions
        for ($index = $indexTransactionBegin; $index < count($this->getElements()); $index++) {

            // Parcourir chacune des informations d'une transaction
            $attributes = explode(PHP_EOL, $this->getElements()[$index]);

            $listTransactions[] = new Transaction(
                $this->getAttributeDate($attributes),
                $this->getAttributeNote($attributes),
                $this->getAttributeAmount($attributes),
                $this->getAttributeRecipient($attributes),
                $this->getAttributeCategory($attributes),
            );
        }

        return $listTransactions;
    }

    private function setElements(): void {
        $this->elements = array_filter(
            explode(self::END_ELEMENT, $this->content),
            fn($value) => !is_null($value) && trim($value) !== ""
        );
    } 

    private function getElements(): array {
        return $this->elements;
    }

    private function getAttributeDate(array $attributes): string {
        return $this->getAttributGeneric($attributes, self::RULE_ATTRIBUTE_DATE);
    }

    private function getAttributeNote(array $attributes): string {
        return $this->getAttributGeneric($attributes, self::RULE_ATTRIBUTE_NOTE);
    }

    private function getAttributeAmount(array $attributes): string {
        return $this->getAttributGeneric($attributes, self::RULE_ATTRIBUTE_AMOUNT);
    }

    private function getAttributeRecipient(array $attributes): string {
        return $this->getAttributGeneric($attributes, self::RULE_ATTRIBUTE_RECIPIENT);
    }

    private function getAttributeCategory(array $attributes): string {
        return $this->getAttributGeneric($attributes, self::RULE_ATTRIBUTE_CATEGORY);
    }

    private function getAttributGeneric(
        array $attributes,
        string $regexRule
    ): string {
        $attributsFound = preg_grep($regexRule, $attributes);
        return substr(array_shift($attributsFound), 1);
    }
}
