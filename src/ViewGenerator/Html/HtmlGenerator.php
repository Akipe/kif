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
        $cssContent = file_get_contents(__DIR__ . "/style.css");

        if (empty($cssContent)) {
            throw new Exception(__DIR__ . "/style.css does not exist or does not contain data");
        }

        $this->generator->setStyle($cssContent);

        $startDateFormatted = $this->dateFormater->format(
            $this->account->getFirstTransactionDate()
        );
        $endDateFormatted = $this->dateFormater->format(
            $this->account->getLastTransactionDate()
        );

        $this->generator->setTitle(
            "Relevé de \"" . $this->account->name . "\" - " . $this->configuration->getStructureName()
        );
        $this->generator->setInformation(
            'Du <span class="description-important">' .
            $startDateFormatted .
            '</span> au <span class="description-important">' .
            $endDateFormatted .
            '</span> avec un solde initial à <span class="description-important">' .
            $this->account->amountStart .
            ' €</span> ' .
            'et un solde final à <span class="description-important">' .
            $this->account->getClosingAmount() .
            ' €</span>'
        );

        $this->generator->setTabHeader(
            [
                [
                    "cssClass" => "title-date",
                    "data" => "Date",
                ],
                [
                    "cssClass" => "title-recipient",
                    "data" => "Tiers",
                ],
                [
                    "cssClass" => "title-note",
                    "data" => "Remarque",
                ],
                [
                    "cssClass" => "title-debit",
                    "data" => "Débit",
                ],
                [
                    "cssClass" => "title-credit",
                    "data" => "Crédit",
                ],
                [
                    "cssClass" => "title-balance",
                    "data" => "Solde",
                ],
            ]
        );

        $this->generator->addTabLine(
            [
                [
                    "cssClass" => "opening-date",
                    "data" => $this->account->getFirstTransactionDate()->format("d/m/Y"),
                ],
                [
                    "cssClass" => "opening-note",
                    "data" => mb_strtoupper("Solde initial"),
                ],
                [
                    "cssClass" => "",
                    "data" => "",
                ],
                [
                    "cssClass" => "",
                    "data" => "",
                ],
                [
                    "cssClass" => "",
                    "data" => "",
                ],
                [
                    "cssClass" => "opening-balance",
                    "data" => number_format($this->account->getOpeningAmount(), 2, ',', ' '),
                ],
            ]
        );

        $this->generator->addTabLine(
            [
                [
                    "cssClass" => "",
                    "data" => "",
                ],
                [
                    "cssClass" => "",
                    "data" => "",
                ],
                [
                    "cssClass" => "",
                    "data" => "",
                ],
                [
                    "cssClass" => "",
                    "data" => "",
                ],
                [
                    "cssClass" => "",
                    "data" => "",
                ],
                [
                    "cssClass" => "",
                    "data" => "",
                ],
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

        $this->generator->addTabLine(
            [
                [
                    "cssClass" => "",
                    "data" => "",
                ],
                [
                    "cssClass" => "",
                    "data" => "",
                ],
                [
                    "cssClass" => "",
                    "data" => "",
                ],
                [
                    "cssClass" => "",
                    "data" => "",
                ],
                [
                    "cssClass" => "",
                    "data" => "",
                ],
                [
                    "cssClass" => "",
                    "data" => "",
                ],
            ]
        );

        $this->generator->addTabLine(
            [
                [
                    "cssClass" => "closing-date",
                    "data" => $this->account->getLastTransactionDate()->format("d/m/Y"),
                ],
                [
                    "cssClass" => "closing-note",
                    "data" => mb_strtoupper("Solde final"),
                ],
                [
                    "cssClass" => "",
                    "data" => "",
                ],
                [
                    "cssClass" => "",
                    "data" => "",
                ],
                [
                    "cssClass" => "",
                    "data" => "",
                ],
                [
                    "cssClass" => "closing-balance",
                    "data" => number_format($this->account->getClosingAmount(), 2, ',', ' '),
                ],
            ]
        );

        return $this->generator->generateTabPageTemplate();
    }
}
