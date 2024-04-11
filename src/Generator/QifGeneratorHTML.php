<?php

namespace Akipe\Kif\Generator;

use Akipe\Kif\Html\HtmlGenerator;

class QifGeneratorHTML 
{
    private HtmlGenerator $generator;

    function __construct(
        public readonly array $transactions,
    ){
        $this->generator = new HtmlGenerator();
    }

    /**
     * 
     * @return array{html: string, css: string} 
     */
    public function generate(string $cssFilePath): array {
        $output = [];

        $this->generator->setStyle(
            file_get_contents(__DIR__ . "/style.css")
        );
        $this->generator->setTabHeader(
            "Date",
            "Note",
            "Bénéficiaire",
            "Catégorie",
            "Débit",
            "Crédit",
        );

        
        foreach ($this->transactions as $transaction) {
            if ($transaction->amount < 0) {
                $debit = [
                    "cssClass" => "debit",
                    "data" => number_format($transaction->amount, 2, ',', ' '),
                ];
                $credit = [
                    "cssClass" => "credit",
                    "data" => '',
                ];
            } else {
                $debit = [
                    "cssClass" => "debit",
                    "data" => '',
                ];
                $credit = [
                    "cssClass" => "credit",
                    "data" => number_format($transaction->amount, 2, ',', ' '),
                ];
            }



            $this->generator->addTabLine(
                [
                    "cssClass" => "date",
                    "data" => ucfirst($transaction->date),
                ],
                [
                    "cssClass" => "note",
                    "data" => ucwords($transaction->note),
                ],
                [
                    "cssClass" => "recipient",
                    "data" => ucwords($transaction->recipient),
                ],
                [
                    "cssClass" => "category",
                    "data" => ucfirst($transaction->category),
                ],
                $debit,
                $credit,
            );
        };

        return [
            "css" => $this->generator->generateCssStyle(),
            "html" => $this->generator->generateTabPageTemplate($cssFilePath),
        ];
    }
}
