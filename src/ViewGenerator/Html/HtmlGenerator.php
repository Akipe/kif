<?php

namespace Akipe\Kif\ViewGenerator\Html;

use IntlDateFormatter;
use Akipe\Kif\Entity\Account;
use Akipe\Kif\Environment\Configuration;
use Akipe\Lib\Html\HtmlGenerator as Html;
use Akipe\Kif\ViewGenerator\ViewGenerator;
use Exception;

class HtmlGenerator implements ViewGenerator
{
    private Html $generator;
    private IntlDateFormatter $dateFormater;
    private Configuration $configuration;
    private Account $account;

    public function __construct()
    {
        $this->generator = new Html();
        $this->setDateFormater();
        $this->configuration = new Configuration();
    }

    public function load(Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    private function setDateFormater(): void
    {
        $this->dateFormater = new IntlDateFormatter(
            'fr_FR',
            IntlDateFormatter::NONE,
            IntlDateFormatter::NONE
        );
        $this->dateFormater->setPattern('EEEE dd MMMM YYYY'); // Exemple : "jeudi 20 février 2020"
    }

    public function generate(): string
    {
        if (empty($cssContent = file_get_contents(__DIR__ . "/style.css"))) {
            throw new Exception(__DIR__ . "/style.css does not exist or does not contain data");
        }

        $this->generator->setStyle($cssContent);

        $startDateFormated = $this->dateFormater->format(
            $this->account->getFirstTransactionDate()
        );
        $endDateFormated = $this->dateFormater->format(
            $this->account->getLastTransactionDate()
        );

        $this->generator->setTitle(
            "Relevé de \"" . $this->account->name . "\" - " . $this->configuration->getStructureName()
        );
        $this->generator->setInformation(
            "Du " . $startDateFormated . " au " . $endDateFormated .
            " avec un solde de " . $this->account->amountStart . " € à " . $this->account->getClosingAmount() . " €"
        );

        $this->generator->setTabHeader(
            [
                "Date",
                "Tiers",
                "Remarque",
                "Débit",
                "Crédit",
                "Solde",
            ]
        );

        foreach ($this->account->transactions as $transaction) {
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
                    [
                        "cssClass" => "date",
                        "data" => $transaction->date->format("d/m/Y"),
                    ],
                    [
                        "cssClass" => "recipient",
                        "data" => ucwords($transaction->recipient),
                    ],
                    [
                        "cssClass" => "note",
                        "data" => ucwords($transaction->note),
                    ],
                    $debit,
                    $credit,
                    [
                        "cssClass" => "balance",
                        "data" => number_format($transaction->getBalance(), 2, ',', ' '),
                    ],
                ]
            );
        };

        return $this->generator->generateTabPageTemplate();
    }
}
