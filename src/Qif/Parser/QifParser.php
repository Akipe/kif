<?php

include_once __DIR__ . "/../Element/QifTransaction.php";
include_once __DIR__ . "/QifElementParser.php";

class QifParser
{
    public const FIRST_TRANSACTION_RULE = "!Type:Bank";

    /** @var string[] */
    private readonly array $elements;

    public function __construct(
        private string $content,
    ) {
        $this->setElements();
    }

    /**
     * Get all transactions
     * 
     * @return QifTransaction[]
     */
    public function getTransactions(): array {
        $listTransactions = [];

        // Parcourir toutes les transactions
        for (
            $index = $this->getFirstTransactionIndex();
            $index < count($this->elements);
            $index++
        ) {

            $listTransactions[] = 
                (new QifElementParser($this->elements[$index]))
                ->getElement();
        }

        return $listTransactions;
    }

    /**
     * Parsing elements ending from separator in string format
     * 
     * @return void
     */
    private function setElements(): void {
        $this->elements = array_filter(
            explode(QifElementParser::ELEMENT_SEPARATOR, $this->content),
            fn($line) => !is_null($line) && trim($line) !== ""
        );
    }

    /**
     * Get first transaction index needed for get all next transactions
     * 
     * @return int First transaction index
     */
    private function getFirstTransactionIndex(): int {
        $indexTransactionBegin = 0;

        foreach($this->elements as $index => $element) {
            if (str_contains($element, self::FIRST_TRANSACTION_RULE)) {
                $indexTransactionBegin = $index;
                break;
            }
        }

        return $indexTransactionBegin;
    }
}
