<?php

namespace Akipe\Kif\Generator;

use Akipe\Kif\Html\HtmlGenerator;

class QifGeneratorHTML 
{
    public const style = "
        td {
            border: 1px solid black;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
    ";

    private HtmlGenerator $generator;

    function __construct(
        public readonly array $transactions,
    ){
        $this->generator = new HtmlGenerator();
    }

    public function generate(): string {
        $this->generator->setStyle(self::style);
        $this->generator->setTabHeader(
            "Date",
            "Note",
            "Montant",
            "Bénéficiaire",
            "Catégorie",
        );

        foreach ($this->transactions as $transaction) {
            $this->generator->addTabLine(
                $transaction->date,
                $transaction->note,
                $transaction->amount,
                $transaction->recipient,
                $transaction->category,
            );
        };

        return $this->generator->generateTabPageTemplate();
    }
}
