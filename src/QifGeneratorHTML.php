<?php

include_once "Transaction.php";

class QifGeneratorHTML 
{
    public const css = "";

    function __construct(
        public readonly array $transactions,
    ){}

    private function getElementsVue() {
        $vue = "<tbody>" . PHP_EOL;

        foreach ($this->transactions as $transaction) {
            $vue .= "<tr>" . PHP_EOL;
            $vue .= "<th>" . $transaction->date . "</th>" . PHP_EOL;
            $vue .= "<th>" . $transaction->note . "</th>" . PHP_EOL;
            $vue .= "<th>" . $transaction->amount . "</th>" . PHP_EOL;
            $vue .= "<th>" . $transaction->recipient . "</th>" . PHP_EOL;
            $vue .= "<th>" . $transaction->category . "</th>" . PHP_EOL;
            $vue .= "</tr>" . PHP_EOL;
        }

        $vue .= "</tbody>" . PHP_EOL;

        return $vue;
    }

    public function generate() {
        return "<!doctype html>
        <html>
            <head>
                <style>
                    td{
                        border:1px solid black;
                    }
                    table{
                        width:100%;
                        border-collapse:collapse;
                    }
                </style>
            </head>
            <body>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Note</th>
                            <th>Montant</th>
                            <th>Bénéficiaire</th>
                            <th>Catégorie</th>
                        </tr>
                    </thead>"
        . $this->getElementsVue() . 
        "
                </table>
            </body>
        </html>";
    }
}
